<?php
namespace Jan\Foundation;


use Exception;
use Jan\Component\DI\Contracts\ContainerInterface;
use Jan\Component\Http\Contracts\RequestInterface;
use Jan\Component\Routing\Exception\MethodNotAllowedException;
use Jan\Component\Routing\Exception\RouterException;
use Jan\Component\Routing\Route;


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
     * RouteDispatcher constructor.
     *
     * @param RequestInterface $request
     * @param ContainerInterface $container
     * @throws MethodNotAllowedException
     * @throws RouterException
     */
     public function __construct(RequestInterface $request, ContainerInterface $container)
     {
         $route = Route::instance()->match($request->getMethod(), $request->getPath());

         if(! $route)
         {
             throw new Exception('Route not found', 404);
         }

         $this->route = $route;
         $this->container = $container;
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
      * @return mixed
     */
     public function getRouteMiddleware()
     {
         return $this->route['middleware'];
     }


    /**
     * @return mixed
     * @throws Exception
    */
    public function callAction()
    {
        $target = $this->route['target'];
        $parameters = $this->route['matches'];

        if(is_string($target))
        {
            list($controller, $action) = explode('@', $target);
            $controller = $this->namespace.$controller;
            $reflectedMethod = new \ReflectionMethod($controller, $action);
            $parameters = $this->resolveActionParams($reflectedMethod);
            $target = [$this->container->get($controller), $action];
        }

        if(! is_callable($target))
        {
            throw new Exception('No callable action!');
        }

        return call_user_func_array($target, $parameters);
    }


    /**
     * @param \ReflectionMethod $reflectedMethod
     * @return
    */
    private function resolveActionParams(\ReflectionMethod $reflectedMethod)
    {
        return $this->container->getDependencies(
            $reflectedMethod,
            $this->route['matches']
        );
    }
}