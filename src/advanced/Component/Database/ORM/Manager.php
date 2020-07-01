<?php
namespace Jan\Component\Database\ORM;


use Exception;
use Jan\Component\Database\Connection\PDO\Statement;
use Jan\Component\Database\Database;
use PDO;

/**
 * Class Manager
 * @package Jan\Component\Database\ORM
*/
class Manager
{

      /**
       * @var Statement
      */
      private static $statement;


      /**
        * @param PDO|null $connection
        * @throws Exception
      */
      public static function connect(PDO $connection = null)
      {
          if(! $connection)
          {
              $connection = Database::pdo()->getConnection();
          }

          self::$statement = new Statement($connection);
      }


      /**
        * @return Statement
      */
      public static function getStatement()
      {
          return self::$statement;
      }

}