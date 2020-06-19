<?php
namespace Jan\Foundation\Http;


use Jan\Component\DI\Contracts\ContainerInterface;
use Jan\Component\Http\Contracts\RequestInterface;
use Jan\Component\Http\Contracts\ResponseInterface;
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
    }


    /**
     * @param RequestInterface $request
     * @return ResponseInterface
     * @throws \Exception
    */
    public function handle(RequestInterface $request): ResponseInterface
    {
          //
    }


    /**
     * @param RequestInterface $request
     * @param ResponseInterface $response
    */
    public function terminate(RequestInterface $request, ResponseInterface $response)
    {
          //
    }


}