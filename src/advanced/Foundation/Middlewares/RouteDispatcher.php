<?php
namespace Jan\Foundation\Middlewares;


use Jan\Component\DI\Contracts\ContainerInterface;
use Jan\Component\Http\Contracts\MiddlewareInterface;
use Jan\Component\Http\Contracts\RequestInterface;
use Jan\Component\Http\Contracts\ResponseInterface;


/**
 * Class RouteDispatcher
 * @package Jan\Foundation\Middlewares
*/
class RouteDispatcher implements MiddlewareInterface
{


    /** @var ContainerInterface  */
    private $container;



    /**
     * RouteDispatcher constructor.
     * @param ContainerInterface $container
    */
    public function __construct(ContainerInterface $container)
    {
         $this->container = $container;
    }


    /**
     * @param RequestInterface $request
     * @param ResponseInterface $response
     * @param callable $next
     * @return mixed
    */
    public function __invoke(RequestInterface $request, ResponseInterface $response, callable $next)
    {
         return $next($request, $response);
    }
}