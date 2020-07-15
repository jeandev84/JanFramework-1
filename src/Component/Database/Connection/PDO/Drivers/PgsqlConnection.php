<?php
namespace Jan\Component\Database\Connection\PDO\Drivers;


use Jan\Component\Database\Connection\PDO\PDOConnection;


/**
 * Class PgsqlConnection
 * @package Jan\Component\Database\Connection\PDO\Drivers
*/
class PgsqlConnection extends PDOConnection
{
     /**
      * @return string
     */
     public function getDriverName()
     {
         return 'pgsql';
     }
}