<?php
namespace Jan\Component\Routing;


use Closure;


/**
 * Class Route
 * @package Jan\Component\Routing
*/
class Route
{

     /**
      * @var Router
     */
     private static $router;


     /**
      * Get instance of router
      *
      * @return Router
     */
     public static function instance()
     {
        if(! self::$router)
        {
            self::$router = new Router();
        }

        return static::$router;
     }


     /**
      * @param $method
      * @param $arguments
      * @return mixed
     */
     public static function __callStatic($method, $arguments)
     {
          // $router = new Router();
          $router = self::instance();

          if(method_exists($router, $method))
          {
              return call_user_func_array([$router, $method], $arguments);
          }
     }
}
