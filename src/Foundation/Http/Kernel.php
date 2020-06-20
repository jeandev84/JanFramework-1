<?php
namespace Jan\Foundation\Http;


use Jan\Component\DI\Contracts\ContainerInterface;
use Jan\Component\Http\Contracts\RequestInterface;
use Jan\Component\Http\Contracts\ResponseInterface;
use Jan\Component\Http\Response;
use Jan\Contracts\Http\Kernel as HttpKernelContract;
//use Jan\Foundation\RouteDispatcher;



/**
 * Class Kernel
 * @package Jan\Foundation\Http
 */
class Kernel implements HttpKernelContract
{

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
        try {

            $dispatcher = new \Jan\Foundation\RouteDispatcher($request);
            $dispatcher->setBaseUrl('http://localhost:8080');
            $dispatcher->setControllerNamespace('App\\Http\\Controllers');
            $response = $dispatcher->callAction();

        } catch (\Exception $e) {

            exit('404 Page not found');
        }

        return $response;
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
}