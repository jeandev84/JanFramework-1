<?php
namespace Jan\Foundation\Facades;


use Jan\Component\Routing\Router;


/**
 * Class Route
 * @package Jan\Foundation\Facades
*/
class Route
{


     private static $instance;


     /**
      * Route constructor.
     */
     public static function instance()
     {
         if(! self::$instance)
         {
             self::$instance = new Router();
         }

         return self::$instance;
     }



     /**
      * @param $method
      * @param $arguments
      * @return mixed
     */
     public static function __callStatic($method, $arguments)
     {
         if(method_exists(self::instance(), $method))
         {
             return call_user_func_array([self::instance(), $method], $arguments);
         }
     }
}