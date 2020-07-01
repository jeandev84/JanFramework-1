<?php
namespace Jan\Component\Database;


use Exception;
use Jan\Component\Database\Connection\PDO\Drivers\MySqlConnection;
use Jan\Component\Database\Connection\PDO\Drivers\SqliteConnection;
use Jan\Component\Database\Exceptions\DatabaseException;
use PDO;


/**
 * Class Database
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


      /**
       * Return void
      */
      public static function disconnect()
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


      /**
       * @return mixed
       * @throws Exception
      */
      public static function pdo()
      {
          $driver = strtolower(self::config('driver'));

          foreach (self::pdoDrivers() as $connection)
          {
               $pattern = '#^'. $connection->getDriverName() .'$#i';
               if(preg_match($pattern, $driver))
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
           return 'nothing';
      }


      /**
       * @return mixed|string
       * @throws Exception
      */
      public static function getConnection()
      {
           if(! self::$connection)
           {
               return null;
           }

           return self::$connection->getConnection();
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
    protected static function pdoDrivers()
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