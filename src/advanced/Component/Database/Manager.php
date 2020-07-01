<?php
namespace Jan\Component\Database;


use Exception;
use Jan\Component\Database\Connection\PDO\Statement;
use PDO;


/**
 * Class Manager
 * @package Jan\Component\Database
*/
class Manager
{

     /**
      * @var Statement
     */
     private static $statement;


    /**
     * @param array $config
     * @throws Exceptions\DatabaseException
     * @throws Exception
     */
     public static function connect(array $config = [])
     {
         Database::connect($config);

         if(($pdo = Database::pdo()->getConnection()) instanceof PDO)
         {
             self::$statement = new Statement($pdo);
         }
     }


     /**
      * Get PDO Statement
      *
      * @return Statement
      * @throws Exception
     */
     public static function getStatement()
     {
         if(! self::$statement)
         {
             throw new Exception('Can not get pdo statement, look at your connection!');
         }

         return self::$statement;
     }
}