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

     /**
      * @var array
     */
     private static $config = [
        'type'       => 'pdo', // mysqli
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
        'engine'     => 'InnoDB',
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

          foreach (self::pdoDrivers() as $connection)
          {
               $pattern = '#^'. $driver .'$#i';
               if(preg_match($pattern, $connection->getDriverName()))
               {
                    return $connection;
               }
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
            self::config('engine'),
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
     * @return array
     * @throws Exception
    */
    public static function pdoDrivers()
    {
        return [
            new MySqlConnection(
                self::getDsnDriver('mysql'),
                self::config('username'),
                self::config('password'),
                self::config('options')
            ),
            new SqliteConnection(
                self::getDsnDriver('sqlite'),
                null,
                null,
                self::config('options')
            ),
            new PgsqlConnection(
                self::getDsnDriver('pgsql'),
                self::config('username'),
                self::config('password'),
                self::config('options')
            ),
            new OracleConnection(
                self::getDsnDriver('oci'),
                self::config('username'),
                self::config('password'),
                self::config('options')
            )
        ];

    }


    /**
     * @param string $driver
     * @return string
    */
    private static function getDsnDriver(string $driver)
    {
        $dsn = $driver .':';

        switch ($driver)
        {
            case 'sqlite':
                $dsn .= self::config('database');
            break;

            default:
                $dsn .= sprintf('host=%s;port=%s;dbname=%s;charset=%s',
                    self::config('host'),
                    self::config('port'),
                    self::config('database'),
                    self::config('charset')
                );
        }

        return $dsn;
    }
}