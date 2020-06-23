<?php
namespace Jan\Component\Database;


use Exception;
use PDO;

/**
 * Class QueryStatement
 * @package Jan\Component\Database
*/
class QueryStatement
{

       /**
        * @var Connection
       */
       protected $connection;


        /**
         * QueryStatement constructor.
         * @param PDO|null $connection
         * @throws Exception
       */
       public function __construct(PDO $connection = null)
       {
           if(! $connection)
           {
               $connection = Database::instance();
           }

           $this->connection = $connection;
       }


       /**
         * @param $sql
         * @param array $params
       */
       public function execute($sql, $params = [])
       {
           dd($this->connection);
       }
}