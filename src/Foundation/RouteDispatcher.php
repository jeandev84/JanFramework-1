<?php
namespace Jan\Foundation;


use Closure;
use Jan\Component\Http\Contract\RequestInterface;
use Jan\Component\Routing\Exception\MethodNotAllowedException;
use Jan\Component\Routing\Route;
use Jan\Component\Templating\Asset;


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
      * @param RequestInterface $request
      * @throws MethodNotAllowedException
     */
     public function __construct(RequestInterface $request)
     {
         $route = $this->match($request);

         if(! $route)
         {
             throw new \Exception('Route not found', 404);
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
      * @param string $baseUrl
     */
     public function setBaseUrl(string $baseUrl)
     {
         Route::router()->setBaseUrl($baseUrl);
         Asset::instance()->setBaseUrl($baseUrl);
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
      * @param array $middleware
      * @return RouteDispatcher
     */
     public function setMiddleware(array $middleware)
     {
         $this->middleware = array_merge($this->route['middleware'], $middleware);

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


     /**
      * Return route params if current request matched
      *
      * @param RequestInterface $request
      * @return array|bool
      * @throws MethodNotAllowedException
     */
     public function match(RequestInterface $request)
     {
         return Route::router()->match(
             $request->getMethod(),
             $request->getPath()
         );
     }
}