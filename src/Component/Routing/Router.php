<?php
namespace Jan\Component\Routing;


use Jan\Component\Routing\Contracts\RouterInterface;
use Jan\Component\Routing\Exception\MethodNotAllowedException;
use Jan\Component\Routing\Exception\RouterException;


/**
 * Class Router
 * @package Jan\Component\Routing
 *
 * http://localhost:8080/post/5/article-4?page=3&sort=asc
*/
class Router implements RouterInterface
{

      /**
       * @var array
      */
      private $route = [];


      /**
       * @var array
      */
      private $routes = [];


      /**
       * @var array
      */
      private $namedRoutes = [];


      /**
       * @var array
      */
      private $patterns = [
          'id'   => '[0-9]+',
          'slug' => '[a-z\-0-9]+'
      ];


      /**
       * @var array
      */
      private $formatParams = [
          '{([\w]+)}',
          ':([\w]+)'
      ];


      /**
       * @var array
      */
      private $middleware = [];


      /**
       * @var string
      */
      private $baseUrl;


      /**
       * Router constructor.
       * @param string $baseUrl
      */
      public function __construct(string $baseUrl = '')
      {
           $this->setBaseUrl($baseUrl);
      }



      /**
       * @param string $baseUrl
       * @return $this
      */
      public function setBaseUrl(string $baseUrl)
      {
          $this->baseUrl = $baseUrl;

          return $this;
      }


      /**
       * @return string
      */
      public function getBaseUrl()
      {
          return $this->baseUrl;
      }


      /**
       * Set routes
       *
       * @param array $routes
      */
      public function setRoutes(array $routes)
      {
          $this->routes = $routes;
      }



      /**
       * Get all routes
       *
       * @return array
      */
      public function getRoutes()
      {
         return $this->routes;
      }


      /**
       * @return array
      */
      public function namedRoutes()
      {
          return $this->namedRoutes;
      }


      /**
       * Get all patterns
       *
       * @return array|string[]
      */
      public function patterns()
      {
          return $this->patterns;
      }


      /**
       * Get current route
       *
       * @return array
      */
      public function getRoute()
      {
          return $this->route;
      }


     /**
      * Get all routes middlewares
      *
      * @return array
     */
     public function middlewares()
     {
         return $this->middleware;
     }


     /**
      * @param array $methods
      * @param string $path
      * @param $target
      * @param string|null $name
      * @return Router
      * @throws RouterException
     */
     public function map(array $methods, string $path, $target, string $name = null)
     {
          $route = compact('methods', 'path', 'target');
          $this->routes[] = $this->route = $route;
          $this->routeName($name, $path);
          return $this;
     }


    /**
     * Determine if current route path match URI
     *
     * @param string|null $requestMethod
     * @param string|null $requestUri
     * @return array|bool
     * @throws MethodNotAllowedException
     * @throws RouterException
     */
     public function match(string $requestMethod = null, string $requestUri = null)
     {
         foreach ($this->routes as $route)
         {
             list($methods, $path) = array_values($route);

             if(! \in_array($requestMethod, $methods))
             {
                  throw new MethodNotAllowedException();
             }

             $pattern = $this->generatePattern($path);

             if(preg_match($pattern, $this->getUrlPath($requestUri), $matches))
             {
                 return array_merge($route, [
                     'pattern' => $pattern,
                     'matches' => $this->filteredMatchParams($matches),
                     'name' => $this->getPathName($path),
                     'middleware' => $this->getMiddleware($path)
                 ]);
             }
         }

         return false;
     }



    /**
     * @param array $middleware
     * @return Router
     */
    public function middleware(array $middleware = [])
    {
        $this->middleware[$this->route['path']] = $middleware;

        return $this;
    }



    /**
     * @param string $name
     * @return $this
     * @throws RouterException
    */
    public function name(string $name)
    {
        $this->routeName($name, $this->route['path']);
        return $this;
    }


    /**
     * Generate route path
     *
     * @param string $name
     * @param array $params
     * @return mixed
     */
    public function generate(string $name, array $params = [])
    {
        if(! isset($this->namedRoutes[$name]))
        {
             $queryString = $params ? http_build_query($params) : '';
             return $this->generateUrl($name, $queryString);
        }

        $path = $this->namedRoutes[$name];

        if($params)
        {
            foreach($params as $k => $v)
            {
                $path = preg_replace(["#{{$k}}#", "#:{$k}#"], $v, $path);
            }
        }

        return  $this->generateUrl($path);
    }


    /**
     * @param string $path
     * @param string $queryString
     * @return string
   */
    public function generateUrl(string $path, string $queryString = '')
    {
        $qs = $queryString ? '?'. $queryString : '';
        return rtrim($this->baseUrl, '/') . '/' . trim($path, '/') . $qs;
    }


    /**
     * Set regular expression requirement on the route
     * @param $name
     * @param null $expression
     *
     * @return Router
    */
    public function where($name, $expression = null)
    {
        foreach ($this->parseWhere($name, $expression) as $name => $expression)
        {
            $this->patterns[$name] = $expression;
        }

        return $this;
    }



    /**
     * @param string $path
     * @return array|mixed
     */
    private function getMiddleware(string $path)
    {
        return $this->middleware[$path] ?? [];
    }


    /**
     * @param $matches
     * @return array
    */
    private function filteredMatchParams($matches)
    {
        return array_filter($matches, function ($key) {
            return ! is_numeric($key);
        }, ARRAY_FILTER_USE_KEY);
    }



    /**
      * @param string $path
      * @return string
    */
    private function generatePattern(string $path)
    {
         return '#^'. $this->compile(trim($path, '/')) . '$#i';
    }



    /**
     * @return array
    */
    private function getFormatParams()
    {
        $formats = [];
        foreach ($this->formatParams as $format)
        {
            $formats[] = '#'. $format . '#';
        }
        return $formats;
    }



    /**
      * @param string $path
      * @return string
     */
     private function compile(string $path)
     {
         return preg_replace_callback($this->getFormatParams(), [$this, 'generateRegex'], $path);
     }



     /**
      * @param array $matches
      * @return string
     */
     private function generateRegex(array $matches)
     {
         if($this->hasPattern($matches[1]))
         {
             return '(?P<'. $matches[1] .'>'. $this->resolvePattern($matches[1]) . ')';
         }
         return '([^/]+)';
     }


     /**
      * Determine if has setted pattern
      *
      * @param $key
      * @return bool
     */
     private function hasPattern($key)
     {
        return isset($this->patterns[$key]);
     }



     /**
      * @param $key
      * @return string|string[]
     */
     private function resolvePattern($key)
     {
        return str_replace( '(', '(?:', $this->patterns[$key]);
     }



    /**
     * Determine parses
     *
     * @param $name
     * @param $expression
     * @return array
    */
    private function parseWhere($name, $expression)
    {
        return \is_array($name) ? $name : [$name => $expression];
    }


    /**
     * Get URL path
     *
     * @param string $url
     * @return string
     * @throws RouterException
    */
    private function getUrlPath(string $url)
    {
        return trim(parse_url($url, PHP_URL_PATH), '/');
    }



    /**
     * @param string $path
     * @return false|int|string
    */
    private function getPathName(string $path)
    {
        return array_search($path, $this->namedRoutes) ?: '';
    }



    /**
      * Set path name
      *
      * @param $name
      * @param $path
      * @throws RouterException
    */
    private function routeName($name, $path)
    {
         if($name)
         {
             if(isset($this->namedRoutes[$name]))
             {
                 throw new RouterException('This name (%s) already taken!');
             }

             $this->namedRoutes[$name] = $path;
         }
    }

}