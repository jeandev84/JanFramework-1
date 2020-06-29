<?php
namespace Jan\Component\Database;


use Closure;
use Exception;
use Jan\Component\Database\Exceptions\DatabaseException;
use PDO;
use PDOException;
use PDOStatement;
use stdClass;


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
           'engine'    => 'InnoDB'
       ];


       /**
        * @var array
       */
       private static $records = [];


       /**
        * @var PDOStatement
       */
       private static $statement;


       /**
        * @var string
       */
       private static $classMap = stdClass::class;



       private function __construct() {}
       private function __wakeup() {}


        /**
         * Make connection
         *
         * @param array $config
         * @return PDO
         * @throws DatabaseException
       */
       public static function connect(array $config = [])
       {
           self::setConfiguration($config);
           return self::instance();
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
         * @param string $sql
         * @param array $params
         * @param string $classMap
         * @return Database
         * @throws Exception
       */
       public static function query(string $sql, array $params = [], string $classMap = stdClass::class)
       {
           try {

               self::$statement = self::instance()->prepare($sql);

               if(self::$statement->execute($params))
               {
                   self::$records[] = compact('sql', 'params');
               }

               self::$classMap = $classMap;

           } catch (PDOException $e) {

                throw $e;
           }

           return new self();
       }


       /**
        * Create database if not exist
       */
       public static function create()
       {
           $sql = 'CREATE DATABASE '. self::config('database') . ' IF NOT EXISTS';
           self::exec(
               sprintf('CREATE DATABASE %s IF NOT EXISTS',
               self::config('database')
               )
           );
       }


       /**
         * @param string $table
         * @param string $columns
         * @throws Exception
       */
       public static function schema(string $table, string $columns)
       {
           $sql = sprintf(
           'CREATE TABLE `%s` IF NOT EXISTS (
                   %s
                   ) ENGINE = %s DEFAULT CHARSET=%s',
                   $table,
                   $columns,
                   self::config('engine'),
                   self::config('charset')
           );

           self::exec($sql);
       }


       /**
        * @throws Exception
       */
       public static function beginTransaction()
       {
           self::instance()->beginTransaction();
       }


       /**
        * @throws Exception
       */
       public static function rollback()
       {
            self::instance()->rollBack();
       }


       /**
        * @throws Exception
       */
       public static function commit()
       {
            self::instance()->commit();
       }


       /**
        * @param Closure $callback
        * @throws Exception
       */
       public static function transaction(Closure $callback)
       {
           try {

               self::beginTransaction();
               $callback();
               self::commit();

           } catch (PDOException $e) {

               self::rollback();
               throw $e;
           }
       }



       /**
        * @param string $sql
        * @throws Exception
       */
       public static function exec(string $sql)
       {
           try {

               if(self::instance()->exec($sql))
               {
                   self::$records[] = compact('sql');
               }

           } catch (PDOException $e) {

                 throw $e;
           }
       }



       /**
        * @param int|string $fetchStyle
        * @return array
       */
       public function get(string $fetchStyle = PDO::FETCH_OBJ)
       {
          if(self::$classMap)
          {
             return self::$statement->fetchAll(PDO::FETCH_CLASS, self::$classMap);
          }

          return self::$statement->fetchAll($fetchStyle);
       }



       public function first()
       {
           //
       }


       public function one()
       {
           //
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
         * @param array $config
         * @throws DatabaseException
       */
       public static function setConfiguration(array $config)
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