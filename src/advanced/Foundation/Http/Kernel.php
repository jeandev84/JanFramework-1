<?php
namespace Jan\Foundation\Http;


use Jan\Component\DI\Container;
use Jan\Component\DI\Contracts\ContainerInterface;
use Jan\Component\Http\Contracts\RequestInterface;
use Jan\Component\Http\Contracts\ResponseInterface;
use Jan\Component\Routing\Route;
use Jan\Component\Routing\Router;
use Jan\Contracts\Http\Kernel as HttpKernelContract;
use Jan\Component\Http\Middleware;
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
        try {

            $response = $this->dispatchRoute($request);

        } catch (\Exception $e) {

            if($e->getCode() == 404)
            {
                exit('404 Page not found');
            }

            exit($e->getMessage());
        }

        return $response;
    }


    /**
     * @param RequestInterface $request
     * @return mixed
     */
    protected function dispatchRoute(RequestInterface $request)
    {
         $response = $this->container->get(ResponseInterface::class);
         $dispatcher = $this->container->get(RouteDispatcher::class);
         $dispatcher->middlewareGroup($this->middlewares);
         return $dispatcher->dispatch($request, $response);
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