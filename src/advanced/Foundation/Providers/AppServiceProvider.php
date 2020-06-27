<?php
namespace Jan\Foundation\Providers;


use Jan\Component\DI\Container;
use Jan\Component\DI\Contracts\BootableServiceProvider;
use Jan\Component\DI\Contracts\ContainerInterface;
use Jan\Component\DI\ServiceProvider\ServiceProvider;
use Jan\Component\Dotenv\Env;
use Jan\Component\Http\Contracts\RequestInterface;
use Jan\Component\Http\Contracts\ResponseInterface;
use Jan\Component\Http\Request;
use Jan\Component\Http\Response;


/**
 * Class AppServiceProvider
 * @package Jan\Foundation\Providers
*/
class AppServiceProvider extends ServiceProvider implements BootableServiceProvider
{

    /**
     * @return mixed
    */
    public function boot()
    {
        $this->loadEnvironments();
    }



    /**
     * @return mixed
    */
    public function register()
    {
        # A ameliorer avec implements interfaces
        $this->container->singleton(ContainerInterface::class, function () {
            return $this->container;
        });

        $this->container->singleton(Request::class, function () {
            return Request::fromGlobals();
        });

        $this->container->singleton(RequestInterface::class, function () {
            return $this->container->get(Request::class);
        });


        $this->container->singleton(Response::class, function () {
           return new Response();
        });


        $this->container->singleton(ResponseInterface::class, function () {
            return $this->container->get(Response::class);
        });
    }


    /**
     * Load environment variables
    */
    protected function loadEnvironments()
    {
        try {

            $dotenv = (new Env($this->container->get('base.path')))->load();

        } catch (\Exception $e) {
            exit($e->getMessage());
        }
    }

}