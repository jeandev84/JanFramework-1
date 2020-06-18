<?php
namespace Jan\Foundation;


use Jan\Component\Routing\Route;


/**
 * Class RouteDispatcher
 * @package Jan\Foundation
*/
class RouteDispatcher
{

     /**
      * @var array
     */
     private $route;


    /**
     * RouteDispatcher constructor.
     * @param string $requestMethod
     * @param string $requestUri
     * @throws \Exception
     */
     public function __construct(string $requestMethod, string $requestUri)
     {
         $route = Route::router()->match($requestMethod, $requestUri);

         if(! $route)
         {
             exit('404 Page not found');
             // throw new \Exception('Route not found', 404);
         }

         $this->route = $route;
     }


     /**
      * @return array|bool
     */
     public function getRoute()
     {
         return $this->route;
     }


     /**
      * Call action
     */
     public function callAction()
     {
         dump($this->route);
         return true;
     }
}