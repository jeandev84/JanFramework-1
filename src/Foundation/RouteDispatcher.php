<?php
namespace Jan\Foundation;


use Closure;
use Jan\Component\Routing\Route;


/**
 * Class RouteDispatcher
 * @package Jan\Foundation
*/
class RouteDispatcher
{

     /**
      * @var // ContainerInterface
     */
     private $container;


     /**
      * Target namespace
      *
      * @var string
     */
     private $namespace;


     /**
      * Route parameters
      *
      * @var array
     */
     private $route = [];


     /**
      * Middleware stack
      *
      * @var array
     */
     private $middleware = [];



     /**
      * RouteDispatcher constructor.
      *
      * TODO Implement, parse constructor argument like : __construct(RequestInterface $request)
      * @param string $requestMethod
      * @param string $requestUri
      * @throws \Exception
     */
     public function __construct(string $requestMethod, string $requestUri)
     {
         $route = Route::router()->match($requestMethod, $requestUri);

         if(! $route)
         {
             exit('404 Page not found');
             // throw new \Exception('Route not found', 404);
         }

         $this->route = $route;
     }


     /**
      * @return array|bool
     */
     public function getRoute()
     {
        return $this->route;
     }


     /**
      * @param $container
      * @return RouteDispatcher
     */
     public function setContainer($container)
     {
          $this->container = $container;

          return $this;
     }



     /**
      * @param string $namespace
      * @return RouteDispatcher
     */
     public function setControllerNamespace(string $namespace)
     {
          $this->namespace = rtrim($namespace, '\\') .'\\';

          return $this;
     }


     /**
      * @param array $middlewares
      * @return RouteDispatcher
     */
     public function setMiddleware(array $middlewares)
     {
         $this->middleware = array_merge($this->route['middleware'], $middlewares);

         return $this;
     }


     /**
      * Call action
     */
     public function callAction()
     {
         $callback = $this->route['target'];

         if(is_string($callback))
         {
             $callback = str_replace('@', '::', $this->namespace . $callback);
         }

         if(! is_callable($callback))
         {
             return $callback;
         }

         call_user_func_array($callback, $this->route['matches']);

         dump($this->route);
         return true;
     }
}