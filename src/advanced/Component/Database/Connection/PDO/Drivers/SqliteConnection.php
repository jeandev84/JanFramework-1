<?php
namespace Jan\Component\Database\Connection\PDO\Drivers;


use Jan\Component\Database\Connection\PDO\Connection;
use Jan\Component\Database\Connection\PDO\Driver;

/**
 * Class SqliteConnection
 * @package Jan\Component\Database\Connection\PDO\Drivers
*/
class SqliteConnection extends Connection
{

    /**
     * @return string
    */
    public function getDriverName()
    {
        return 'sqlite';
    }
}