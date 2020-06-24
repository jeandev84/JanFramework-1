<?php
namespace Jan\Foundation\Providers;


use Jan\Component\DI\ServiceProvider\ServiceProvider;
use Jan\Component\Http\Contracts\RequestInterface;
use Jan\Component\Http\Middleware;
use Jan\Foundation\RouteDispatcher;


/**
 * Class RouteServiceProvider
 * @package Jan\Foundation\Providers
*/
class RouteServiceProvider extends ServiceProvider
{

    /**
     * @return mixed
    */
    public function register()
    {
         $this->container->singleton(RouteDispatcher::class, function () {
             $request = $this->container->get(RequestInterface::class);
             $dispatcher = new RouteDispatcher($request, $this->container);
             $dispatcher->setControllerNamespace('App\\Http\\Controllers');
             return $dispatcher;
         });

         $this->container->singleton(Middleware::class, function () {
             return new Middleware();
         });
    }
}