<?php
namespace Jan\Foundation\Providers;


use Jan\Component\DI\ServiceProvider\ServiceProvider;
use Jan\Component\Templating\View;


/**
 * Class ViewServiceProvider
 * @package Jan\Foundation\Providers
*/
class ViewServiceProvider extends ServiceProvider
{

    /**
     * @return mixed
    */
    public function register()
    {
        $this->container->singleton('view', function () {
            return new View($this->container->get('base.path').'/templates/views/');
        });
    }
}