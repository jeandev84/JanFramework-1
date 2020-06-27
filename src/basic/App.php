<?php
namespace Jan;


use Closure;
use Jan\Component\DI\Container;
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
     * @param Closure $closure
     * @param null $name
     * @return Router
     * @throws Component\Routing\Exception\RouterException
   */
    public function map($methods, $path, Closure $closure, $name = null)
    {
        $request = null; // $this->get(RequestInterface::class);
        $response = null; // $this->get(ResponseInterface::class);
        return Route::instance()->map($methods, $path, $closure($request, $response), $name);
    }



    public function run()
    {
          /*
          if($target instanceof Closure)
          {
              $target($request, $response)
          }
          */
    }
}