<?php
namespace Jan\Foundation\Providers;


use Jan\Component\DI\ServiceProvider\ServiceProvider;
use Jan\Component\FileSystem\FileSystem;


/**
 * Class FileSystemServiceProvider
 * @package Jan\Foundation\Providers
*/
class FileSystemServiceProvider extends ServiceProvider
{

    /**
     * @return mixed
    */
    public function register()
    {
        $this->container->singleton(FileSystem::class, function () {

           return new FileSystem(
               $this->container->get('base.path')
           );
        });
    }
}