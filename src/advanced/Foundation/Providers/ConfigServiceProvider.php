<?php
namespace Jan\Foundation\Providers;


use Jan\Component\Config\Config;
use Jan\Component\Config\Loaders\ArrayLoader;
use Jan\Component\DI\Contracts\BootableServiceProvider;
use Jan\Component\DI\ServiceProvider\ServiceProvider;
use Jan\Component\FileSystem\FileSystem;


/**
 * Class ConfigurationServiceProvider
 * @package Jan\Foundation\Providers
*/
class ConfigServiceProvider extends ServiceProvider implements BootableServiceProvider
{

    /** @var ArrayLoader */
    private $arrayLoader;


    /**
     * @return mixed
    */
    public function boot()
    {
        $fs = $this->container->get(FileSystem::class);

        $resources = $fs->resources('/config/*.php');
        $data = [];

        foreach ($resources as $resource)
        {
            $filename = pathinfo($resource)['filename'];
            $data[$filename] = $resource;
        }

        $this->arrayLoader = new ArrayLoader($data);
    }


    /**
     * @return mixed
    */
    public function register()
    {
        $this->container->singleton('config', function () {
            return (new Config())->load([
                $this->arrayLoader,
                // json loader
                // xml loader
                //..
            ]);
        });
    }

}