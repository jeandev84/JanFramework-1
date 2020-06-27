<?php
namespace Jan\Component\Database;


use Exception;
use Jan\Component\Database\Exceptions\DatabaseException;
use PDO;
use PDOException;

/**
 * Class Database
 * @package Jan\Component\Database
*/
class Database
{

       /**
        * @var Database
       */
       private static $instance;


       /**
        * @var array
       */
       private static $config = [
           'driver'    => '',
           'database'  => '',
           'host'      => '',
           'port'      => '',
           'charset'   => '',
           'username'  => '',
           'password'  => '',
           'collation' => '',
           'options'   => '',
           'prefix'    => '',
           'engine'    => ''
       ];


       private function __construct() {}
       private function __wakeup() {}


       /**+
        * @param array $config
        * @throws DatabaseException
       */
       public static function connect(array $config)
       {
            foreach ($config as $key => $value)
            {
                if(! \array_key_exists($key, self::$config))
                {
                     throw new DatabaseException(
                         sprintf('Key (%s) is not valid database config param!', $key)
                     );
                }

                self::$config[$key] = $value;
            }
       }


       /**
        * Get instance connection to database
        *
        * @return array|Database
        * @throws \Exception
       */
       public static function instance()
       {
           if(! self::$instance)
           {
               self::$instance = self::pdo();
           }

           return self::$instance;
       }


       /**
        * @return PDO
        * @throws Exception
       */
       public static function pdo()
       {
           try {

               $driver = self::config('driver');

               if(! \in_array($driver, PDO::getAvailableDrivers()))
               {
                    throw new Exception(
                        sprintf('Driver (%s) is not available!', $driver)
                    );
               }

               $dsn = $driver .':';

               $username = self::config('username');
               $password = self::config('password');
               $options = self::config('options');

               if($driver === 'sqlite')
               {
                   $dsn .= self::config('database');
                   $username = null;
                   $password = null;

               } else {

                   $dsn .= 'host='. self::config('host');;
                   $dsn .= 'dbname='. self::config('database');
                   $dsn .= 'charset='. self::config('charset');
               }

               return new PDO(strtolower($dsn), $username, $password, $options);

           } catch (PDOException $e) {

               echo '<div>'. $e->getMessage() . '</div>';
               throw $e;
           }
       }



      /**
       * @param $key
       * @return mixed|null
      */
      public static function config($key)
      {
          return self::$config[$key] ?? null;
      }
}