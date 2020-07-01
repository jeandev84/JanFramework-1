<?php
namespace Jan\Component\Database\Connection\PDO\Drivers;


use Jan\Component\Database\Connection\PDO\Connection;


/**
 * Class OracleConnection
 * @package Jan\Component\Database\Connection\PDO\Drivers
*/
class OracleConnection extends Connection
{
       /**
         * @return string
       */
       public function getDriverName()
       {
           return 'oci';
       }
}