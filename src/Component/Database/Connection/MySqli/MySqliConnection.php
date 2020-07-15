<?php
namespace Jan\Component\Database\Connection\MySqli;


use Jan\Component\Database\Connection\ConnectionInterface;
use mysqli;



/**
 * Class MySqliConnection
 * @package Jan\Component\Database\Connection\MySqli
*/
class MySqliConnection implements ConnectionInterface
{


     /** @var  */
     protected $connection;


     /**
      * MySqliConnection constructor.
      *
      * @param string $host
      * @param string $username
      * @param string $password
     */
     public function __construct(string $host, string $username, string $password)
     {
         $connection = new mysqli($host, $username, $password);

         if($error = $connection->connect_error)
         {
              exit('Connection failed : '. $error);
         }

         $this->connection = $connection;
     }


     /**
      * @return mixed
     */
     public function getConnection()
     {
         return $this->connection;
     }

}