<?php
namespace Jan\Component\Database\Connection\PDO;


use App\Migrations\Version202005061548;
use Exception;
use Jan\Component\Database\Table\Migration;
use PDO;



/**
 * Class Migrator
 * @package Jan\Component\Database\Connection\PDO
*/
class Migrator
{

    /**
     * @var string
    */
    private $table = 'migrations';


    /**
     * @var array
    */
    private $migrations = [];


    /**
     * @var Statement
    */
    private $statement;


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
     * Table name version
     *
     * @param string $table
     * @return Migrator
    */
    public function setBaseTable(string $table)
    {
        $this->table = $table;
        return $this;
    }


    /**
     * Get migration table
     *
     * @return string
    */
    public function getMigrationTable()
    {
         return $this->version;
    }


    /**
     * @param array $migrations
     * @return Migrator
    */
    public function setMigrations(array $migrations)
    {
        foreach ($migrations as $migration)
        {
            $this->addMigration($migration);
        }

        return $this;
    }


    /**
     * @param Migration $migration
    */
    public function addMigration(Migration $migration)
    {
         // via \ReflectionObject()
         // can get name of migration, path of migration
         $this->migrations[] = $migration;
    }


    /**
     * @return array
    */
    public function migrations()
    {
        return $this->migrations;
    }


    /**
     * Generate migration
    */
    public function generate()
    {
        /*
        $migrations = [
          new Version202005061548(),
          new Version202005061548(),
          new Version202005061548()
        ];
        */

        //
        // dd($this->statement);
    }


    /**
     * @param string $direction
    */
    protected function run(string $direction = 'up')
    {
        // create table version 'migrations' if not exist and indicate fields (version, created_at, updated_at))
        // and register in this table name of migration
        foreach ($this->migrations as $migration)
        {
              switch ($direction)
              {
                  case 'up':
                      $migration->up();
                  break;

                  case 'down':
                      $migration->down();
                  break;
              }
        }
    }



    /**
     *  Migrate table to the database
    */
    public function migrate()
    {
        $this->run('up');
    }


    /**
     * Truncate table from the database
    */
    public function rollback()
    {
         $this->migrations = [];
    }


    /**
     * Drop table from the database
    */
    public function reset()
    {
        $this->run('down');
    }
}