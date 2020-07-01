<?php
namespace Jan\Component\Database\Connection;


/**
 * Interface ConnectionInterface
 * @package Jan\Component\Database\Connection
*/
interface ConnectionInterface
{
     /**
      * @return mixed
     */
     public function getConnection();


     /**
      * @param string $sql
      * @return mixed
     */
     public function query($sql);
}