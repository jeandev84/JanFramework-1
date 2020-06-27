<?php
namespace Jan;


use Closure;
use Exception;
use Jan\Component\DI\Container;
use Jan\Component\Http\Contracts\RequestInterface;
use Jan\Component\Http\Contracts\ResponseInterface;
use Jan\Component\Http\Request;
use Jan\Component\Http\Response;
use Jan\Component\Routing\Route;
use Jan\Component\Routing\Router;



/**
 * Class App
 * @package Jan
*/
class App extends Container
{

    /**
     * @param $methods
     * @param $path
     * @param Closure $callback
     * @param null $name
     * @return Router
     * @throws Component\Routing\Exception\RouterException
    */
    public function map($methods, $path, Closure $callback, $name = null)
    {
        return Route::instance()->map($methods, $path, $callback, $name);
    }


    /**
     * @param RequestInterface|null $request
     * @param ResponseInterface|null $response
     * @return void
     * @throws Component\Routing\Exception\MethodNotAllowedException
     * @throws Component\Routing\Exception\RouterException
     * @throws Exception
     */
    public function run(RequestInterface $request = null, ResponseInterface $response = null)
    {
         if(! $request)
         {
             $request = new Request();
         }

         if(! $response)
         {
             $response = new Response();
         }

         $route = Route::instance()->match($request->getMethod(), $request->getPath());

         if(! $route)
         {
             throw new Exception('No found route', 404);
         }

         $target = $route['target'];

         if($target instanceof Closure)
         {
             $matches = $route['matches'];
             return $target($request, $response);
         }
    }
}