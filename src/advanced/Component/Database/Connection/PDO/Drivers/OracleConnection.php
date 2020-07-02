<?php
namespace Jan\Component\Database\Connection\PDO\Drivers;


use Jan\Component\Database\Connection\PDO\PDOConnection;


/**
 * Class OracleConnection
 * @package Jan\Component\Database\Connection\PDO\Drivers
*/
class OracleConnection extends PDOConnection
{
       /**
         * @return string
       */
       public function getDriverName()
       {
           return 'oci';
       }
}