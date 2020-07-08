<?php
namespace Jan\Foundation\Providers;


use Jan\Component\DI\ServiceProvider\ServiceProvider;
use Jan\Foundation\Loader;


/**
 * Class LoaderServiceProvider
 * @package Jan\Foundation\Providers
*/
class LoaderServiceProvider extends ServiceProvider
{

    /**
     * @return mixed
     */
    public function register()
    {
        $this->container->singleton(Loader::class, function () {
            return new Loader($this->container);
        });
    }
}