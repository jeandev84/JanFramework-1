<?php
namespace Jan\Foundation\Providers;


use Jan\Component\DI\ServiceProvider\ServiceProvider;
use Jan\Component\Http\Contracts\RequestInterface;
use Jan\Component\Http\Middleware;
use Jan\Component\Routing\Route;
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
         $this->container->singleton('middleware', function () {
            return new Middleware();
         });

         $this->container->singleton(RouteDispatcher::class, function () {
             $dispatcher = new RouteDispatcher($this->container);
             $dispatcher->namespace('App\\Http\\Controllers');
             return $dispatcher;
         });
    }
}