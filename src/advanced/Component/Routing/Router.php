<?php
namespace Jan\Component\Routing;


use Closure;
use Exception;
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
      private $options = [];


      /**
       * @var array
      */
      private $namedRoutes = [];


      /**
       * @var array
      */
      private $matches = [];


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
      * @param array $options
      * @param \Closure $callback
     */
     public function group(array $options, \Closure $callback)
     {
         $this->options = $options;
         $callback();
         $this->options = $options;
     }


    /**
     * @param $prefix
     * @param Closure $callback
    */
    public function prefix($prefix, Closure $callback)
    {
        $this->group(compact('prefix'), $callback);
    }


    /**
     * @param $namespace
     * @param Closure $callback
    */
    public function namespace($namespace, Closure $callback)
    {
        $this->group(compact('namespace'), $callback);
    }

     /**
      * @param string $path
      * @param $target
      * @param string|null $name
      * @return $this
      * @throws RouterException
     */
     public function get(string $path, $target, string $name = null)
     {
          return $this->map(['GET'], $path, $target, $name);
     }


    /**
     * @param string $path
     * @param $target
     * @param string|null $name
     * @return $this
     * @throws RouterException
    */
     public function post(string $path, $target, string $name = null)
     {
         return $this->map(['POST'], $path, $target, $name);
     }


    /**
     * @param string $path
     * @param $target
     * @param string|null $name
     * @return $this
     * @throws RouterException
     */
    public function put(string $path, $target, string $name = null)
    {
        return $this->map(['PUT'], $path, $target, $name);
    }


    /**
     * @param string $path
     * @param $target
     * @param string|null $name
     * @return $this
     * @throws RouterException
    */
    public function delete(string $path, $target, string $name = null)
    {
        return $this->map(['DELETE'], $path, $target, $name);
    }



    /**
     * @param $methods
     * @param string $path
     * @param $target
     * @param string|null $name
     * @return Router
     * @throws RouterException
     * @throws Exception
    */
    public function map(array $methods, string $path, $target, string $name = null)
    {
          $route = compact('methods', 'path', 'target');
          $this->routes[] = $this->route = $route;
          $this->setRouteName($name, $path);
          return $this;
    }


    /**
     * @param $methods
     * @return array|false|string[]
     * @throws Exception
    */
    /*
    private function mapMethods($methods)
    {
        if(is_array($methods))
        {
            return $methods;
        }

        if(is_string($methods))
        {
            return explode('|', $methods);
        }

        throw new Exception('Methods must to be array or string seperated by "|"');
    }
    */

    /**
     * Determine if current route path match URI
      *
      * @param string $requestMethod
      * @param string $requestUri
      * @return array|bool
     */
     public function match(string $requestMethod, string $requestUri)
     {
         foreach ($this->routes as $route)
         {
             list($methods, $path) = array_values($route);

             if($this->isMathMethods($requestMethod, $methods) && $this->isMatchPaths($path, $requestUri))
             {
                 return array_merge($route, $this->getNewParams($path));
             }
         }

         return false;
     }


     /**
      * @param $path
      * @return array
     */
     private function getNewParams($path)
     {
         return [
             'pattern' => $this->generatePattern($path),
             'matches' => $this->getFilteredMatchParams(),
             'name' => $this->getPathName($path),
             'middleware' => $this->getMiddleware($path)
         ];
     }


     /**
      * @param string $path
      * @param string $requestUri
      * @return array|bool
     */
     private function isMatchPaths(string $path, string $requestUri)
     {
         $pattern = $this->generatePattern($path);
         $uri = $this->getPathUrl($requestUri);
         $matches = [];

         if(preg_match($pattern, $uri, $matches))
         {
             $this->setMatches($matches);
             return true;
         }
         return false;
     }


      /**
       * @param string $requestMethod
       * @param array $methods
       * @return bool
      */
      private function isMathMethods(string $requestMethod, array $methods)
      {
           return \in_array($requestMethod, $methods);
      }


     /**
      * @param array $matches
      */
      private function setMatches(array $matches)
      {
         $this->matches = $matches;
      }


     /**
      * @return array
     */
     private function getMatches()
     {
         return $this->matches;
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
        $this->setRouteName($name, $this->route['path']);
        return $this;
    }




    /**
     * @param string $path
     * @return false|int|string
     */
    public function getPathName(string $path)
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
    public function setRouteName($name, $path)
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


    /**
     * @param $name
     * @return bool|mixed
    */
    public function getRoutePath($name)
    {
        return $this->namedRoutes[$name] ?? false;
    }


    /**
     * Generate route path
     *
     * @param string $context
     * @param array $params
     * @return mixed
    */
    public function generate(string $context, array $params = [])
    {
        if(! isset($this->namedRoutes[$context]))
        {
             return $this->generateUrl($context, http_build_query($params));
        }

        $path = $this->namedRoutes[$context];

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
     * @param string $qs [ query string ]
     * @return string
     */
    public function generateUrl(string $path, string $qs = '')
    {
        return rtrim($this->baseUrl, '/') .
               '/' . trim($path, '/') . ($qs ? '?'. $qs : $qs);
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
     * @return array
    */
    private function getFilteredMatchParams()
    {
        $matches = $this->getMatches();
        return array_filter($matches, function ($key) {
            return ! is_numeric($key);
        }, ARRAY_FILTER_USE_KEY);
    }



    /**
      * @param string $path
      * @return string
    */
    public function generatePattern(string $path)
    {
         return '#^'. $this->compile(trim($path, '/')) . '$#i';
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
     * Get URL path
     *
     * @param string $url
     * @return string
    */
    public function getPathUrl(string $url)
    {
        return trim(parse_url($url, PHP_URL_PATH), '/');
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
}