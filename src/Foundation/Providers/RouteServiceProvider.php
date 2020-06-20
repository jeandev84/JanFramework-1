<?php
namespace Jan\Foundation\Providers;


use Jan\Component\DI\ServiceProvider\ServiceProvider;
use Jan\Component\Http\Contracts\RequestInterface;
use Jan\Foundation\Middleware;
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
             $dispatcher = new RouteDispatcher($this->container->get(RequestInterface::class));
             $dispatcher->setControllerNamespace('App\\Http\\Controllers');
             $dispatcher->setContainer($this->container);
             return $dispatcher;
         });

         $this->container->singleton(Middleware::class, function () {
             return new Middleware();
         });
    }
}