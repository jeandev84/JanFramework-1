<?php
namespace Jan\Component\Database\Migration;



/**
 * Class Migration
 * @package Jan\Component\Database\Migration
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