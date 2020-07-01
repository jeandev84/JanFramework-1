<?php
namespace Jan\Component\Database\Migration;


use Jan\Component\Database\Manager;
use Jan\Component\Database\Exceptions\DatabaseException;
use PDO;

/**
 * Class Migrator
 * @package Jan\Component\Database\Migration
*/
class Migrator
{

    /**
     * @var string
    */
    private $migrationTable = 'migrations';


    /**
     * @var PDO
    */
    protected $connection;


    /**
     * Migration constructor.
     * @param PDO|null $connection
    */
    public function __construct(PDO $connection = null)
    {
         if(! $connection)
         {
             $connection = Manager::pdo();
         }

         $this->connection = $connection;
    }


    /**
     * @param Migration $migration
     * @param string $direction
    */
    public function run(Migration $migration, $direction = 'up')
    {

    }



    /**
     *  Migrate table to the database
    */
    public function migrate()
    {
       //
    }


    /**
     * Truncate table from the database
    */
    public function rollback()
    {
        //
    }


    /**
     * Drop table from the database
    */
    public function reset()
    {
        //
    }
}