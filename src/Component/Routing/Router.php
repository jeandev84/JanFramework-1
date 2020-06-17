<?php
namespace Jan\Component\Routing;


use Jan\Component\Routing\Exception\MethodNotAllowedException;
use Jan\Component\Routing\Exception\RouterException;


/**
 * Class Router
 * @package Jan\Component\Routing
*/
class Router
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
       * Add routes
       *
       * @param array $routes
      */
      public function setRoutes(array $routes)
      {
          $this->routes = $routes;
      }


      /**
       * Set format param
       *
       * @param array $formatParams
       * @return Router
      */
      public function setFormatParam(array $formatParams)
      {
          $this->formatParams = array_merge($this->formatParams, $formatParams);
          return $this;
      }


      /**
       * @return array
      */
      public function getFormatParams()
      {
           $formats = [];
           foreach ($this->formatParams as $format)
           {
               $formats[] = '#'. $format . '#';
           }
           return $formats;
      }


      /**
       * Get all routes
       *
       * @return array
      */
      public function routes()
      {
         return $this->routes;
      }


     /**
      * Get current route
      *
      * @return array
     */
     public function route()
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
          $this->routes[] = $this->route = compact('methods', 'path', 'target');
          $this->setPathName($name, $path);
          return $this;
     }


     /**
      * @param $requestMethod
      * @param $requestUri
      * @return array|bool
      * @throws MethodNotAllowedException
     */
     public function match(string $requestMethod, string $requestUri)
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
                     'matches' => $this->filteredMatchParams($matches),
                     'pattern' => $pattern,
                     'name' => $this->getPathName($path),
                     'middleware' => $this->getMiddleware($path)
                 ]);
             }
         }

         return false;
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
      * @param string $path
      * @return string
     */
     private function compile(string $path)
     {
         return preg_replace_callback($this->getFormatParams(), [$this, 'convertParams'], $path);
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
     * @param array $matches
     * @return string
     */
     private function convertParams(array $matches)
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
      * @param array $middleware
      * @return Router
     */
     public function middleware(array $middleware = [])
     {
        $this->middleware[$this->route['path']] = $middleware;

        return $this;
     }



     /**
      * @param string $path
      * @return array|mixed
     */
     public function getMiddleware(string $path)
     {
        return $this->middleware[$path] ?? [];
     }


     /**
      * @param string $name
      * @return $this
      * @throws RouterException
     */
     public function name(string $name)
     {
        $this->setPathName($name, $this->route['path']);
        return $this;
     }


    /**
     * Set regular expression requirement on the route
     * @param $name
     * @param null $expression
     *
     * @return Router
     * @throws RouterException
    */
    public function where($name, $expression = null)
    {
        foreach ($this->parseWhere($name, $expression) as $name => $expression)
        {
            if(isset($this->patterns[$name]))
            {
                throw new RouterException(sprintf(
                        'This name (%s) already setted for expression (%s)',
                        $name, $this->patterns[$name]
                    )
                );
            }

            $this->patterns[$name] = $expression;
        }

        return $this;
    }



    /**
     * @param $name
     * @param array $params
     * @return mixed
     */
     public function generate($name, array $params = [])
     {
        $path = $this->namedRoutes[$name] ?? false;

        if($params)
        {
            foreach($params as $k => $v)
            {
                /* $path = preg_replace(["#{".$k."}#", "#:". $k ."#"], $v, $path); */
            }
        }

        return $path;
     }


     /**
      * Determine parses
      * @param $name
      * @param $expression
      * @return array
     */
     private function parseWhere($name, $expression)
     {
        return \is_array($name) ? $name : [$name => $expression];
     }


     /**
      * @param string $url
      * @return string
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
     private function setPathName($name, $path)
     {
         if($name)
         {
             if(isset($this->namedRoutes[$name]))
             {
                 throw new RouterException('This name (%s) already taken!');
             }

             $this->namedRoutes[$name] = '/'. trim($path, '/');
         }
     }

}