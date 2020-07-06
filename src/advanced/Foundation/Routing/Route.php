<?php
namespace Jan\Foundation\Routing;


use Closure;
use Jan\Component\Routing\Router;


/**
 * Class Route
 * @package Jan\Component\Routing
 *
 * Route facade
*/
class Route
{

     /**
      * @var Router
     */
     private static $instance;


     /**
      * Get instance of router
      *
      * @return Router
     */
     public static function instance()
     {
        if(! self::$instance)
        {
            self::$instance = new Router();
        }

        return static::$instance;
     }


     /**
      * @param $method
      * @param $arguments
      * @return mixed
     */
     public static function __callStatic($method, $arguments)
     {
          $router = self::instance();

          if(method_exists($router, $method))
          {
              return call_user_func_array([$router, $method], $arguments);
          }
     }
}
