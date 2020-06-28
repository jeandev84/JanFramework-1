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

       const DEFAULT_PDO_OPTIONS = [
           PDO::ATTR_PERSISTENT => true, // permit to insert/ persist data in to database
           PDO::ATTR_EMULATE_PREPARES => 0,
           PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
           PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
       ];

       /**
        * @var PDO
       */
       private static $instance;


       /**
        * @var array
       */
       private static $config = [
           'driver'    => 'mysql',
           'database'  => 'janframework',
           'host'      => '127.0.0.1',
           'port'      => '3306',
           'charset'   => 'utf8',
           'username'  => 'root',
           'password'  => '',
           'collation' => 'utf8_unicode_ci',
           'options'   => [],
           'prefix'    => '',
           'engine'    => 'innodb'
       ];


       private function __construct() {}
       private function __wakeup() {}


       /**
         * Make connection
         *
         * @param array $config
         * @return PDO
         * @throws DatabaseException
         * @throws Exception
       */
       public static function connect(array $config = [])
       {
            self::setConfiguration($config);
       }


       /**
         * Get instance connection to database
         *
         * @return PDO
         * @throws Exception
       */
       public static function instance(): PDO
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
                        sprintf('(%s) is not available driver !', $driver)
                    );
               }

               $dsn = sprintf('%s:', $driver);

               $username = self::config('username');
               $password = self::config('password');
               $options = array_merge(self::DEFAULT_PDO_OPTIONS, self::config('options'));

               // TODO Refactoring Drivers
               switch($driver)
               {
                   case 'sqlite':
                       $dsn .= sprintf('%s', self::config('database'));
                       $username = null;
                       $password = null;
                       break;

                   default:
                       $dsn .= sprintf('host=%s;port=%s;dbname=%s;charset=%s',
                           self::config('host'),
                           self::config('port'),
                           self::config('database'),
                           self::config('charset')
                       );
               }

               return new PDO($dsn, $username, $password, $options);

           } catch (PDOException $e) {

               throw $e;
           }
       }


       /**
        * @param $sql
        * @param array $params
       */
       public static function execute($sql, $params = [])
       {

       }


       /**
        * @param $key
        * @return mixed|null
       */
       public static function config($key)
       {
           return self::$config[$key] ?? null;
       }


       /**
        * @param array $config
        * @throws DatabaseException
       */
       private static function setConfiguration(array $config)
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
}