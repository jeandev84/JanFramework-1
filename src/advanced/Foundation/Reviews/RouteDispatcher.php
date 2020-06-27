<?php
namespace Jan\Foundation\Reviews;


use Exception;
use Jan\Component\DI\Container;
use Jan\Component\DI\Exceptions\InstanceException;
use Jan\Component\DI\Exceptions\ResolverDependencyException;
use Jan\Component\Http\Contracts\RequestInterface;
use Jan\Component\Http\Response;
use Jan\Component\Routing\Exception\MethodNotAllowedException;
use Jan\Component\Routing\Exception\RouterException;
use Jan\Component\Routing\Route;
use ReflectionException;
use ReflectionMethod;


/**
 * Class RouteDispatcher
 * @package Jan\Foundation\Reviews
*/
class RouteDispatcher
{

     /**
      * @var Container
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
     * @param Container $container
     * @throws MethodNotAllowedException
     * @throws RouterException
     */
     public function __construct(RequestInterface $request, Container $container)
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
      * @param string|null $key
      * @return array|bool|mixed
     */
     public function getRoute($key = null)
     {
          return $this->route[$key] ?? $this->route;
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
         return $this->getRoute('middleware');
     }


    /**
     * @return Response|mixed
     * @throws InstanceException
     * @throws ReflectionException
     * @throws ResolverDependencyException
     */
    public function callAction()
    {
        $target = $this->getRoute('target');
        $parameters = $this->getRoute('matches');
        $response = false;

        if(is_string($target) && strpos($target, '@') !== false)
        {
            list($controllerClass, $action) = explode('@', $target, 2);
            $controllerClass = sprintf('%s%s', $this->namespace, $controllerClass);
            $reflectedMethod = new ReflectionMethod($controllerClass, $action);
            $parameters = $this->resolveActionParams($reflectedMethod);
            $controller = $this->container->get($controllerClass);
            $target = [$controller, $action];
            $response = true;
        }

        if(! is_callable($target))
        {
            throw new Exception('No callable action!');
        }

        $body = call_user_func_array($target, $parameters);

        if($response && ! $body instanceof Response)
        {
            throw new Exception('This callback must be instance of Response');
        }

        return $body;
    }


    /**
     * @param ReflectionMethod $reflectedMethod
     * @return array
     * @throws InstanceException
     * @throws ResolverDependencyException
     * @throws ReflectionException
    */
    public function resolveActionParams(ReflectionMethod $reflectedMethod)
    {
        return $this->container->getDependencies($reflectedMethod, $this->getRoute('matches'));
    }
}