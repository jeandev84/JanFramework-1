<?php
namespace Jan\Foundation\Http;


use Jan\Component\DI\Contracts\ContainerInterface;
use Jan\Component\Http\Contracts\RequestInterface;
use Jan\Component\Http\Contracts\ResponseInterface;
use Jan\Contracts\Http\Kernel as HttpKernelContract;
use Jan\Foundation\Middleware;
use Jan\Foundation\RouteDispatcher;


/**
 * Class Kernel
 * @package Jan\Foundation\Http
 */
class Kernel implements HttpKernelContract
{

    /**
     * @var string[]
    */
    protected $classAliases = [
        'Route' => 'Jan\\Component\\Routing\\Route'
    ];


    /**
     * @var array
    */
    protected $middlewares = [];



    /**
     * @var array
    */
    protected $routeMiddlewares = [];



    /** @var ContainerInterface */
    protected $container;


    /**
     * Kernel constructor.
     * @param ContainerInterface $container
    */
    public function __construct(ContainerInterface $container)
    {
          $this->container = $container;
          $this->loadClassAliases();
          $this->loadRoutes();
    }


    /**
     * @param RequestInterface $request
     * @return ResponseInterface
     * @throws \Exception
    */
    public function handle(RequestInterface $request): ResponseInterface
    {
        # Route Dispatcher
        $response = $this->container->get(ResponseInterface::class);

        try {

            $dispatcher = $this->container->get(RouteDispatcher::class);
            $middlewares = array_merge($dispatcher->getRouteMiddleware(), $this->middlewares);
            $middlewareManager = $this->container->get(Middleware::class);
            $middlewareManager->addStack($middlewares);
            $response = $middlewareManager->handle($request, $response);
            $body = $dispatcher->callAction();

            if($body instanceof ResponseInterface)
            {
                return $body;
            }

            if(is_array($body))
            {
                return $response->withJson($body);
            }

            return $response->withBody($body);

        } catch (\Exception $e) {

            if($e->getCode() == 404)
            {
                exit('404 Page not found');
            }
            exit($e->getMessage());
        }
    }


    /**
     * @param RequestInterface $request
     * @param ResponseInterface $response
    */
    public function terminate(RequestInterface $request, ResponseInterface $response)
    {
          //
    }


    /**
     *  Load environment variables
    */
    public function loadEnvironments()
    {
         //
    }


    /**
     * Load application configuration
    */
    public function loadConfigurations()
    {
          //
    }


    /**
     * Load routes
    */
    public function loadRoutes()
    {
        require_once $this->container->get('base.path') .'/routes/web.php';

        /* require_once $this->container->get('base.path') .'/routes/*.php'; */
    }


    /**
     * Load classe aliases
    */
    public function loadClassAliases()
    {
        foreach ($this->classAliases as $alias => $original)
        {
            class_alias($original, $alias);
        }
    }

}