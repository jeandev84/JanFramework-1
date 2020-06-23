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
      * @param $methods
      * @param $path
      * @param $target
      * @param null $name
      * @return Router
      * @throws Exception\RouterException
     */
     public static function map($methods, $path, $target, $name = null)
     {
         $methods = is_array($methods) ?? explode('|', $methods);
         $path = self::preparePath($path);
         $target = self::prepareTarget($target);
         return self::instance()->map($methods, $path, $target, $name);
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
     * Add new package or resources of routes
     * Using for system CRUD or api
     *
     *
     * @param string $path
     * @param string $controller
     * @return void
     * Example (path => 'api/', 'controller' => 'PostController')
     * @throws Exception\RouterException
    */
    public static function resource(string $path, string $controller)
    {
        $name = str_replace('/', '.', trim($path, '/'));

        self::get($path.'/', $controller.'@index', $name .'.list');
        self::get($path.'/new', $controller.'@new', $name. '.new');
        self::post($path.'/store', $controller.'@store', $name.'.store');
        self::get($path.'/{id}', $controller.'@show', $name.'.show');
        self::map('GET|POST', $path.'/{id}/edit', $controller.'@edit', $name.'.edit');
        self::delete($path.'/{id}/delete', $controller.'@delete', $name.'.delete');
        self::get($path.'/{id}/restore', $controller.'@restore', $name.'.restore');

    }

    
    /**
     * Get option by given key
     *
     * @param string $key
     * @return mixed
    */
    private static function option(string $key)
    {
        return self::$options[$key] ?? null;
    }


    /**
     * @param $path
     * @return string
    */
    private static function preparePath($path)
    {
        if($prefix = self::option('prefix'))
        {
            $path = rtrim($prefix, '/') . '/'. ltrim($path, '/');
        }
        return $path;
    }


    /**
     * @param $target
     * @return string
    */
    private static function prepareTarget($target)
    {
        if($namespace = self::option('namespace'))
        {
            $target = rtrim($namespace, '\\') .'\\' . $target;
        }
        return $target;
    }
}
