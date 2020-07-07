<?php
namespace Jan\Component\Database;


use Exception;
use Jan\Component\Database\Connection\ConnectionInterface;
use Jan\Component\Database\Connection\PDO\Drivers\MySqlConnection;
use Jan\Component\Database\Connection\PDO\Drivers\OracleConnection;
use Jan\Component\Database\Connection\PDO\Drivers\PgsqlConnection;
use Jan\Component\Database\Connection\PDO\Drivers\SqliteConnection;
use Jan\Component\Database\Connection\PDO\PDOConnection;
use Jan\Component\Database\Connection\PDO\Statement;
use Jan\Component\Database\Exceptions\DatabaseException;



/**
 * Class Manager
 * @package Jan\Component\Database
*/
class Database
{

     const ENGINES = [
        'innodb' => 'InnoDB',
        'myisam' => 'MyISAM'
     ];


     /**
      * @var array
     */
     private static $config = [
        'driver'     => 'mysql',
        'database'   => 'janframework',
        'host'       => '127.0.0.1',
        'port'       => '3306',
        'charset'    => 'utf8',
        'username'   => 'root',
        'password'   => '',
        'collation'  => 'utf8_unicode_ci',
        'options'    => [],
        'prefix'     => '',
        'engine'     => 'innodb', // InnoDB, MyISAM
        'migration_path' => ''
      ];


      /**
       * @var mixed
      */
      protected static $connection;


      /** @var  */
      protected static $instance;


      /**
       * @param array $config
       * @throws DatabaseException
      */
      public static function connect(array $config = [])
      {
           self::setConfiguration($config);

           if (! self::isConnected())
           {
               self::$connection = self::pdo();
           }
      }
      


      /**
       * Return void
      */
      public static function disconnect()
      {
           if(self::isConnected())
           {
               self::$connection = null;
           }
      }


      /**
       * @return PDOConnection
       * @throws Exception
      */
      public static function pdo(): PDOConnection
      {
          $driver = trim(strtolower(self::config('driver')));
          return self::getPDOConnectionByDriver($driver);
      }



      /**
       * @return bool
      */
      public static function isConnected()
      {
          return self::$connection instanceof ConnectionInterface;
      }


      /**
       * @return ConnectionInterface
       * @throws Exception
      */
      public static function getConnector()
      {
           if(! self::isConnected())
           {
                throw new DatabaseException('No connection to database runned!');
           }

           return self::$connection;
      }


      /**
       * @param $sql
       * @param array $params
       * @param string $classMap
       * @return mixed
       * @throws Exception
      */
      public static function execute($sql, $params = [], $classMap = null)
      {
           return self::statement()->query($sql, $params, $classMap);
      }


      /**
       * @param $sql
       * @return mixed|void
       * @throws Exception
      */
      public static function exec($sql)
      {
          return self::statement()->exec($sql);
      }


      /**
       * @return Statement
       * @throws Exception
      */
      public static function statement()
      {
           return new Statement(
               self::getConnector()->getConnection()
           );
      }
      
      
      /**
       * Create database if not exist
       * @throws Exception
      */
      public static function create()
      {
         $sql = sprintf('CREATE DATABASE %s IF NOT EXISTS',
            self::config('database')
         );

         self::execute($sql);
    }


    /**
     * @param string $table
     * @param string $columns
     * @return string
     * @throws Exception
    */
    public static function createTable(string $table, string $columns)
    {
        $sql = sprintf('CREATE TABLE `%s` IF NOT EXISTS (
                 %s
            ) ENGINE=%s DEFAULT CHARSET=%s',
            $table,
            $columns,
            self::getEngine(),
            self::config('charset')
        );

        self::execute($sql);
    }
    

    /**
     * @param $table
     * @throws Exception
    */
    public static function dropTableIfExists($table)
    {
        self::execute(sprintf('DROP TABLE IF EXISTS `%s`', $table));
    }


    /**
     * @param $table
     * @throws Exception
    */
    public static function dropTable($table)
    {
        self::execute(sprintf('DROP TABLE `%s`', $table));
    }



    /**
     * @param $table
     * @throws Exception
    */
    public static function truncate($table)
    {
        self::execute(sprintf('TRUNCATE TABLE %s', $table));
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
                    sprintf('Key (%s) is not valid database configuration param!', $key)
                );
            }

            self::$config[$key] = $value;
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


    /**
     * @param string
     * @return mixed|string|null
    */
    public static function getEngine()
    {
        $engine = self::config('engine');
        return self::ENGINES[$engine] ?? $engine;
    }


    /**
     * @param $driver
     * @return PDOConnection
     * @throws Exception
    */
    public static function getPDOConnectionByDriver($driver)
    {
        foreach (self::connectionStuff($driver) as $connection)
        {
            $pattern = '#^'. $driver .'$#i';

            if(preg_match($pattern, $connection->getDriverName()))
            {
                return $connection;
            }
        }
    }


    /**
     * @param $driver
     * @return string
    */
    private static function getDsnByDriver($driver)
    {
        return sprintf('%s:host=%s;port=%s;dbname=%s;charset=%s',
            $driver,
            self::config('host'),
            self::config('port'),
            self::config('database'),
            self::config('charset')
        );

    }


    /**
     * @param $driver
     * @return array
     * @throws Exception
    */
    private static function connectionStuff($driver)
    {
        $dsn = self::getDsnByDriver($driver);

        return [
            new MySqlConnection($dsn,
                    self::config('username'),
                    self::config('password'),
                    self::config('options')
            ),
            new SqliteConnection(
           $driver.':'. self::config('database'),
       null,
       null,
                self::config('options')
            ),
            new PgsqlConnection($dsn,
                self::config('username'),
                self::config('password'),
                self::config('options')
            ),
            new OracleConnection($dsn,
                    self::config('username'),
                    self::config('password'),
                    self::config('options')
             )
            ];

    }
}