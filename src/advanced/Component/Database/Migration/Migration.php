<?php
namespace Jan\Component\Database\Migration;



/**
 * Class Migration
 * @package Jan\Component\Database\Migration
*/
abstract class Migration
{

    /**
     * @var
    */
    protected $connection;


    /**
     * @param $connection
    */
    public function setConnection($connection)
    {
        $this->connection = $connection;
    }


    /**
     * @return mixed
    */
    public function getConnection()
    {
        return $this->connection;
    }


    /**
     * @return void
    */
    abstract public function up();


    /**
     * @return void
    */
    abstract public function down();
}