<?php
namespace Jan\Component\Database\Migration;


use Exception;
use Jan\Component\Database\Connection\PDO\Statement;
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
     * @var Statement
    */
    protected $statement;


    /**
     * Migration constructor.
     * @param PDO $connection
     * @throws Exception
    */
    public function __construct(PDO $connection)
    {
         $this->statement = new Statement($connection);
    }


    /**
     * Generate migration
    */
    public function generate()
    {
         //
        dd($this->statement);
    }


    /**
     * @param Migration $migration
     * @param string $direction
    */
    public function run(Migration $migration, $direction = 'up')
    {
           switch ($direction)
           {
               case 'up':
                    echo 'Up';
                   break;
               case 'down':
                   echo 'Down';
                   break;
           }
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