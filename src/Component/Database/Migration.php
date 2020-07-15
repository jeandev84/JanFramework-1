<?php
namespace Jan\Component\Database;



/**
 * Class Migration
 * @package Jan\Component\Database
*/
abstract class Migration
{

    /**
     * @return void
    */
    abstract public function up();


    /**
     * @return void
    */
    abstract public function down();
}