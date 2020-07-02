<?php
namespace Jan\Component\Database\Table;


use Closure;
use Exception;
use Jan\Component\Database\Database;

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
         Database::schema($table, $blueprint->buildColumnSql());
     }


     /**
      * @param string $table
      * @throws Exception
     */
     public static function dropIfExists(string $table)
     {
         Database::exec(
             sprintf('DROP TABLE IF EXISTS `%s`', $table)
         );
     }


    /**
     * @param string $table
     * @throws Exception
    */
    public static function drop(string $table)
    {
        Database::exec(
            sprintf('DROP TABLE `%s`', $table)
        );
    }
}