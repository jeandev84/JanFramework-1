<?php
namespace Jan\Component\Database\Migration;


use Jan\Component\Database\Database;
use PDO;

/**
 * Class Migrator
 * @package Jan\Component\Database\Migration
*/
class Migrator
{

    /** @var PDO $connection */
    protected $connection;



    /**
     * Migration constructor.
     * @param PDO $connection
     * @throws \Exception
    */
    public function __construct(PDO $connection = null)
    {
        if(! $connection)
        {
            $connection = Database::instance();
        }

        $this->connection = $connection;
    }


    /**
     * @param string $sql
     */
    public function addSql(string $sql)
    {
        //
    }


    /**
     * @param string $column
     * @return $this
    */
    public function addColumn(string $column)
    {
        return $this;
    }

}