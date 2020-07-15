<?php
namespace Jan\Foundation\Middlewares;


use Jan\Component\Http\Contracts\MiddlewareInterface;
use Jan\Component\Http\Contracts\RequestInterface;
use Jan\Component\Routing\Router;


/**
 * Class RouterMiddleware
 * @package Jan\Foundation\Middlewares
*/
class RouterMiddleware implements MiddlewareInterface
{

    /** @var Router */
    private $router;


    /**
     * RouterMiddleware constructor.
     * @param Router $router
    */
    public function __construct(Router $router)
    {
         $this->router = $router;
    }


    /**
     * @param RequestInterface $request
     * @param callable $next
     * @return mixed
    */
    public function __invoke(RequestInterface $request, callable $next)
    {
         return $next($request);
    }
}