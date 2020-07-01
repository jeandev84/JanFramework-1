<?php
namespace Jan\Component\Database\Connection\PDO;


use App\Migrations\Version202005061548;
use Exception;
use Jan\Component\Database\Migration\Migration;
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
        $migrations = [
          new Version202005061548(),
          new Version202005061548(),
          new Version202005061548()
        ];

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