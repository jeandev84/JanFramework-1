<?php
namespace Jan\Component\Database;


use Exception;
use Jan\Component\Database\Connection\ConnectionInterface;
use Jan\Component\Database\Connection\MySqli\Connection as MySqli;
use Jan\Component\Database\Connection\PDO\Drivers\MySqlConnection;
use Jan\Component\Database\Connection\PDO\Drivers\OracleConnection;
use Jan\Component\Database\Connection\PDO\Drivers\PgsqlConnection;
use Jan\Component\Database\Connection\PDO\Drivers\SqliteConnection;
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
        'type'       => 'pdo', // mysqli (type connection)
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



      /**
       * @param array $config
       * @throws DatabaseException
      */
      public static function connect(array $config = [])
      {
           self::setConfiguration($config);

           if (! self::isConnected())
           {
               switch (self::config('type'))
               {
                   case 'pdo':
                       self::$connection = self::pdo();
                       break;
                   case 'mysqli':
                       self::$connection = self::mysqli();
                       break;
               }
           }
      }


      /**
       * Return void
      */
      public static function disconnect()
      {
           if(self::isConnected())
           {
               switch (self::config('type'))
               {
                   case 'pdo':
                       self::$connection = null;
                       break;
                   case 'mysqli':
                       // mysqli_close(self::$connection);
                       break;
               }
           }
      }


      /**
       * @return mixed
       * @throws Exception
      */
      public static function pdo()
      {
          $driver = trim(strtolower(self::config('driver')));
          $connection = self::getConnectionByDriver($driver);

          $pattern = '#^'. $driver .'$#i';

          if(preg_match($pattern, $connection->getDriverName()))
          {
              return $connection;
          }
      }


      /**
       * @return string
      */
      public static function mysqli()
      {
           return new MySqli();
      }


      /**
       * @return bool
      */
      public static function isConnected()
      {
          return self::$connection instanceof ConnectionInterface;
      }


      /**
       * @return mixed|string
       * @throws Exception
      */
      public static function getConnection()
      {
           if(! self::isConnected())
           {
               return null;
           }

           return self::$connection;
      }


      /**
       * @param $sql
       * @return mixed
       * @throws Exception
      */
      public static function query($sql)
      {
           return self::getConnection()->query($sql);
      }


    /**
     * Create database if not exist
     * @throws Exception
    */
    public static function create()
    {
        self::query(sprintf('CREATE DATABASE %s IF NOT EXISTS',
            self::config('database')
        ));
    }


    /**
     * @param string $table
     * @param string $columnItems
     * @throws Exception
     */
    public static function schema(string $table, string $columnItems = '')
    {
        $sql = sprintf(
        'CREATE TABLE `%s` 
               IF NOT EXISTS (%s) 
               ENGINE = %s DEFAULT 
               CHARSET=%s',
            $table,
            $columnItems,
            self::getEngine(),
            self::config('charset')
        );

        self::query($sql);
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


    /**
     * @param $key
     * @return mixed|null
    */
    public static function config($key)
    {
        return self::$config[$key] ?? null;
    }


    /**
     * @param string $driver
     * @return ConnectionInterface
     * @throws Exception
    */
    private static function getConnectionByDriver($driver)
    {
        $dsn = sprintf('%s:host=%s;port=%s;dbname=%s;charset=%s',
            $driver,
            self::config('host'),
            self::config('port'),
            self::config('database'),
            self::config('charset')
        );

        switch ($driver) {
            case 'mysql':
                return new MySqlConnection($dsn,
                    self::config('username'),
                    self::config('password'),
                    self::config('options')
                );
                break;

            case 'sqlite':
                return new SqliteConnection(
                    $driver.':'. self::config('database'),
                    null,
                    null,
                    self::config('options')
                );
                break;

            case 'pgsql':
                new PgsqlConnection($dsn,
                    self::config('username'),
                    self::config('password'),
                    self::config('options')
                );
                break;

            case 'oci':
                return new OracleConnection($dsn,
                    self::config('username'),
                    self::config('password'),
                    self::config('options')
                );
                break;
        }

    }


    /**
     * @param string
     * @return mixed|string|null
    */
    public static function getEngine()
    {
        $engine = self::config('engine');
        if(isset(self::ENGINES[$engine]))
        {
            return self::ENGINES[$engine];
        }
        return $engine;
    }
}