<?php
namespace Jan\Component\Database\Connection\PDO\Drivers;


use Jan\Component\Database\Connection\PDO\Connection;



/**
 * Class MySqlConnection
 * @package Jan\Component\Database\Connection\PDO\Drivers
*/
class MySqlConnection extends Connection
{


    /**
     * @return string
    */
    public function getDriverName()
    {
        return 'mysql';
    }
}