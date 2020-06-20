<?php
namespace Jan\Foundation\Demo;


use Closure;
use Exception;
use Jan\Component\DI\Contracts\ContainerInterface;
use Jan\Component\Http\Contracts\RequestInterface;
use Jan\Component\Http\Response;
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
      * @var ContainerInterface
     */
     private $container;


     /**
      * target namespace
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
             throw new Exception('Route not found', 404);
         }

         $this->route = $route;
     }


    /**
     * @return array|bool
     */
     public function getDispatchedRoute()
     {
         return $this->route;
     }


     /**
      * @param string $baseUrl
     */
     public function setBaseUrl(string $baseUrl)
     {
         Route::instance()->setBaseUrl($baseUrl);
         Asset::instance()->setBaseUrl($baseUrl);
     }



     /**
      * @param ContainerInterface $container
      * @return RouteDispatcher
     */
     public function setContainer(ContainerInterface $container)
     {
          $this->container = $container;

          return $this;
     }


     /**
      * @return ContainerInterface
     */
     public function getContainer(): ContainerInterface
     {
         return $this->container;
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
     * @return bool
     */
    public function isClosure()
    {
        return $this->route['target'] instanceof Closure;
    }


    /**
     * @return array|mixed
    */
    private function getCallback()
    {
        if($this->isClosure())
        {
            return $this->route['target'];
        }

        list($controller, $action) = explode('@', $this->route['target']);

        return [
            $this->getContainer()->get($this->namespace.$controller),
            $action
        ];
    }


    /**
     * @return mixed
    */
    public function callAction()
    {
        if(is_callable($this->getCallback()))
        {
            //TODO Implement return called
            $body = call_user_func_array($this->getCallback(), $this->route['matches']);
            dump($this->route);
            return new Response($body);
        }
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
         return Route::instance()->match(
             $request->getMethod(),
             $request->getPath()
         );
     }
}