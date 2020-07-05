<?php
namespace Jan\Component\Database;


use Closure;
use Exception;
use Jan\Component\Database\Table\BluePrint;


/**
 * Class Schema
 * @package Jan\Component\Database\Table
*/
class Schema
{

     /**
      * Create table
      *
      * @param string $table
      * @param Closure $closure
      * @throws Exception
     */
     public static function create(string $table, Closure $closure)
     {
         $blueprint = new BluePrint($table);
         $closure($blueprint);
         Database::createTable($table, $blueprint->buildColumnSql());
     }


     /**
      * @param string $table
      * @throws Exception
     */
     public static function dropIfExists(string $table)
     {
         Database::dropTableIfExists($table);
     }


    /**
     * @param string $table
     * @throws Exception
    */
    public static function drop(string $table)
    {
        Database::dropTable($table);
    }
}