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
      * @var array
     */
     private static $options = [];


     /**
      * @var Router
     */
     private static $router;


     /**
      * @return Router
     */
     public static function router()
     {
        if(! self::$router)
        {
            self::$router = new Router();
        }

        return static::$router;
     }


     /**
      * @param $methods
      * @param $path
      * @param $target
      * @param null $name
      * @return Router
      * @throws Exception\RouterException
     */
     public static function map($methods, $path, $target, $name = null)
     {
         if($prefix = self::option('prefix'))
         {
             $path = rtrim($prefix, '/') . '/'. ltrim($path, '/');
         }

         if($namespace = self::option('namespace'))
         {
             $target = rtrim($namespace, '\\') .'\\' . $target;
         }

         return self::router()->map(explode('|', $methods), $path, $target, $name);
     }


     /**
      * @param $path
      * @param $target
      * @param null $name
      * @return Router
      * @throws Exception\RouterException
     */
     public static function get($path, $target, $name = null)
     {
         return self::map('GET', $path, $target, $name);
     }


     /**
      * @param $path
      * @param $target
      * @param null $name
      * @return Router
      * @throws Exception\RouterException
     */
     public static function post($path, $target, $name = null)
     {
        return self::map('POST', $path, $target, $name);
     }


     /**
      * @param $path
      * @param $target
      * @param null $name
      * @return Router
      * @throws Exception\RouterException
     */
     public static function put($path, $target, $name = null)
     {
        return self::map('PUT', $path, $target, $name);
     }


    /**
     * @param $path
     * @param $target
     * @param null $name
     * @return Router
     * @throws Exception\RouterException
    */
    public static function delete($path, $target, $name = null)
    {
        return self::map('DELETE', $path, $target, $name);
    }


    /**
     * @param array $options
     * @param Closure $callback
    */
    public static function group(array $options, Closure $callback)
    {
        self::$options = $options;
        $callback();
        self::$options = [];
    }


    /**
     * @param $prefix
     * @param Closure $callback
    */
    public static function prefix($prefix, Closure $callback)
    {
        self::group(compact('prefix'), $callback);
    }


    /**
     * @param $namespace
     * @param Closure $callback
    */
    public static function namespace($namespace, Closure $callback)
    {
        self::group(compact('namespace'), $callback);
    }


    /**
     * @param string $key
     * @return mixed
    */
    private static function option(string $key)
    {
        return self::$options[$key] ?? null;
    }
}