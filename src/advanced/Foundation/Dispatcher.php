<?php
namespace Jan\Foundation;


use Exception;
use Jan\Component\Http\Contracts\RequestInterface;
use Jan\Component\Http\Response;
use Jan\Component\Routing\Route;


/**
 * Class Dispatcher (RouteDispatcher in reviewing)
 * @package Jan\Foundation
*/
class Dispatcher
{

     private $route;

     private $defaultController;
     private $defaultAction;


     public function __construct(RequestInterface $request)
     {
         $this->route = Route::instance()->match($request->getMethod(), $request->getPath());
     }


     /**
      * @param $key
      * @return mixed|null
     */
     public function getRouteParam($key)
     {
          return $this->route[$key] ?? null;
     }


     /**
      * @param $default
     */
     public function setDefaultController($default)
     {
         $this->defaultController = $default;
     }


     /**
      * @param $action
     */
     public function setDefaultAction($action)
     {
         $this->defaultAction = $action;
     }



     /**
      * @param Response $response
      * @return Response
      * @throws Exception
     */
     public function dispatch(Response $response): Response
     {
         if(! Route::instance()->getRoutes())
         {
              return $this->callAction([$this->defaultController, $this->defaultAction]);
         }

         if(! $this->route)
         {
             throw new Exception('Route not found', 404);
         }


     }


    /**
     * @param $target
     * @param array $params
     * @return mixed
     * @throws \Exception
     */
     public function callAction($target, $params = [])
     {
          if(! is_callable($target))
          {
               throw new \Exception('No callable action');
          }

          return call_user_func($target, $params);
     }
}