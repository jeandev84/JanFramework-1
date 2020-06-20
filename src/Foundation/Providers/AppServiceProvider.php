<?php
namespace Jan\Foundation\Providers;


use Jan\Component\DI\Container;
use Jan\Component\DI\Contracts\ContainerInterface;
use Jan\Component\DI\ServiceProvider\ServiceProvider;
use Jan\Component\Http\Contracts\RequestInterface;
use Jan\Component\Http\Contracts\ResponseInterface;
use Jan\Component\Http\Request;
use Jan\Component\Http\Response;


/**
 * Class AppServiceProvider
 * @package Jan\Foundation\Providers
*/
class AppServiceProvider extends ServiceProvider
{

    /**
     * @return mixed
    */
    public function register()
    {
        $this->container->singleton(ContainerInterface::class, function () {
            return $this->container;
        });

        $this->container->singleton(RequestInterface::class, function () {
            return Request::fromGlobals();
        });

        $this->container->singleton(ResponseInterface::class, function () {
            return new Response();
        });
    }
}