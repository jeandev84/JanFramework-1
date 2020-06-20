<?php
namespace Jan\Foundation;


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
      * @throws \Jan\Component\Routing\Exception\RouterException
     */
     public function __construct(RequestInterface $request)
     {
         $route = Route::instance()->match($request->getMethod(), $request->getPath());

         if(! $route)
         {
             throw new Exception('Route not found', 404);
         }

         $this->route = $route;
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
      * @param Middleware $middlewareManager
     */
     public function runMiddleware(Middleware $middlewareManager)
     {
          foreach ($this->middleware as $middleware)
          {
              $middlewareManager->add($middleware);
          }

         // return $middlewareManager->handle($request, $response);
     }



     /**
      * @return mixed
      * @throws Exception
     */
     public function callAction()
     {
        if(is_callable($this->getCallback()))
        {
             dump($this->route);
             return call_user_func_array($this->getCallback(), $this->route['matches']);
        }
    }


    /**
     * @return array|mixed
     * @throws Exception
    */
    public function getCallback()
    {
        if($this->isClosure() || ! $this->container)
        {
            return $this->route['target'];
        }

        list($controller, $action) = explode('@', $this->route['target']);

        return [
            $this->container->get($this->namespace.$controller),
            $action
        ];
    }


    /**
     * @return bool
    */
    private function isClosure()
    {
        return $this->route['target'] instanceof Closure;
    }
}