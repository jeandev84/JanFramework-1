<?php
namespace Jan\Foundation\Http;


use Jan\Component\DI\Contracts\ContainerInterface;
use Jan\Component\Http\Contracts\RequestInterface;
use Jan\Component\Http\Contracts\ResponseInterface;
use Jan\Component\Http\Response;
use Jan\Component\Routing\Route;
use Jan\Contracts\Http\Kernel as HttpKernelContract;
//use Jan\Foundation\RouteDispatcher;



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

        try {

            // TODO Refactoring create a service provider for Dispatching route
            $response = $this->container->get(ResponseInterface::class);
            $dispatcher = new \Jan\Foundation\RouteDispatcher($request);
            $dispatcher->setControllerNamespace('App\\Http\\Controllers');
            $dispatcher->setContainer($this->container);
            $body = $dispatcher->callAction();
            $response->withBody($body);

        } catch (\Exception $e) {

            echo $e->getMessage() . '<br>';
            exit('404 Page not found');
        }

        // return $response;
        return new Response();
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