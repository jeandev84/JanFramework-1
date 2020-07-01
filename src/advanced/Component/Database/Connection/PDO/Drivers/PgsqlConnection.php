<?php
namespace Jan\Component\Database\Connection\PDO\Drivers;


use Jan\Component\Database\Connection\PDO\Connection;


/**
 * Class PgsqlConnection
 * @package Jan\Component\Database\Connection\PDO\Drivers
*/
class PgsqlConnection extends Connection
{
     /**
      * @return string
     */
     public function getDriverName()
     {
         return 'pgsql';
     }
}