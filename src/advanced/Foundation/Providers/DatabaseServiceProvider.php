<?php
namespace Jan\Foundation\Providers;


use Jan\Component\Database\Database;
use Jan\Component\Database\Exceptions\DatabaseException;
use Jan\Component\DI\Contracts\BootableServiceProvider;
use Jan\Component\DI\ServiceProvider\ServiceProvider;


/**
 * Class DatabaseServiceProvider
 * @package Jan\Foundation\Providers
*/
class DatabaseServiceProvider extends ServiceProvider implements BootableServiceProvider
{

    /**
     * @return mixed
     * @throws DatabaseException
    */
    public function boot()
    {
        $config = $this->container->get('config');
        $params = $config->get('database.'. getenv('DB_CONNECTION'));
        Database::connect($params);
    }


    /**
     * @return mixed
    */
    public function register()
    {
        //
    }
}