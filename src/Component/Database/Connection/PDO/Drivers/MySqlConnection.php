<?php
namespace Jan\Component\Database\Connection\PDO\Drivers;


use Jan\Component\Database\Connection\PDO\PDOConnection;



/**
 * Class MySqlConnection
 * @package Jan\Component\Database\Connection\PDO\Drivers
*/
class MySqlConnection extends PDOConnection
{

    /**
     * @return string
    */
    public function getDriverName()
    {
        return 'mysql';
    }
}