<?php
namespace Jan\Foundation;


use Exception;
use Jan\Component\DI\Container;
use Jan\Component\DI\Contracts\ContainerInterface;
use Jan\Component\DI\Exceptions\InstanceException;
use Jan\Component\DI\Exceptions\ResolverDependencyException;
use Jan\Component\Http\Contracts\RequestInterface;
use Jan\Component\Http\Contracts\ResponseInterface;
use Jan\Component\Http\Response;
use Jan\Component\Routing\Exception\MethodNotAllowedException;
use Jan\Component\Routing\Exception\RouterException;
use Jan\Component\Routing\Route;
use Jan\Component\Routing\Router;
use ReflectionException;
use ReflectionMethod;

/**
 * Class RouteDispatcher
 * @package Jan\Foundation
*/
class RouteDispatcher
{

    /**
     * @var Container
    */
    private $container;



    /**
     * @var string
    */
    private $namespace;


    /**
     * @var array
    */
    private $middleware = [];


    /**
     * RouteDispatcher constructor.
     * @param ContainerInterface $container
    */
    public function __construct(ContainerInterface $container)
    {
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
     * @param array $middleware
    */
    public function middlewareGroup(array $middleware)
    {
        $this->middleware = $middleware;
    }


    /**
     * @param RequestInterface $request
     * @param ResponseInterface $response
     * @return mixed
     * @throws MethodNotAllowedException
     * @throws RouterException
     * @throws InstanceException
     * @throws ResolverDependencyException
     * @throws ReflectionException
     * @throws Exception
    */
    public function dispatch(RequestInterface $request, ResponseInterface $response)
    {
        $router = Route::instance();

        if(! $router->getRoutes())
        {
            return $this->call([$this->container->get(DefaultController::class), 'welcome']);
        }

        $route = $router->match($request->getMethod(), $request->getPath());

        if(! $route)
        {
            throw new Exception('Route not found', 404);
        }

        $target = $route['target'];
        $params = $route['matches'];

        $middleware = $this->container->get('middleware');
        $middleware->addStack(array_merge($route['middleware'], $this->middleware));
        $response = $middleware->handle($request, $response);

        if(is_string($target) && strpos($target, '@') !== false)
        {
            list($controller, $action) = explode('@', $target, 2);
            $body = $this->callAction($controller, $action, $params);

            if(! $body instanceof Response)
            {
                throw new Exception('This callback must be instance of Response');
            }

            return $body;
        }

        $body = $this->call($target, $params);

        if(is_array($body))
        {
            return $response->withJson($body);
        }

        return $response->withBody((string)$body);
    }


    /**
     * @param callable $target
     * @param array $params
     * @return mixed
     * @throws Exception
    */
    public function call($target, $params = [])
    {
        if(! is_callable($target))
        {
            throw new Exception('No callable action!');
        }

        return call_user_func_array($target, $params);
    }


    /**
     * @param string $controller
     * @param string $action
     * @param array $params
     * @return mixed
     * @throws InstanceException
     * @throws ReflectionException
     * @throws ResolverDependencyException
    */
    private function callAction(string $controller, string $action, array $params = [])
    {
        $controller = sprintf('%s%s', $this->namespace, $controller);
        $reflectedMethod = new ReflectionMethod($controller, $action);
        $params = $this->container->get($reflectedMethod, $params);
        return $this->call([$this->container->get($controller), $action], $params);
    }
}