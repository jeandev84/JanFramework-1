<?php
namespace Jan\Foundation;


use Jan\Component\Http\Contracts\MiddlewareInterface;
use Jan\Component\Http\Contracts\RequestInterface;
use Jan\Component\Http\Contracts\ResponseInterface;



/**
 * Class Middleware
 * @package Jan\Foundation
*/
class Middleware
{


       /** @var  mixed */
       protected $start;


       /**
        * MiddlewareStack constructor.
       */
      public function __construct()
      {
          $this->start = function (RequestInterface $request, ResponseInterface $response) {
              return $response;
          };

      }


      /**
       * @param MiddlewareInterface $middleware
       * @return Middleware
      */
      public function add(MiddlewareInterface $middleware)
      {
          $next = $this->start;

          $this->start = function (RequestInterface $request, ResponseInterface $response) use ($middleware, $next) {

                return $middleware->__invoke($request, $response, $next);
          };

          return $this;
      }


      /**
        * @param array $middlewares
      */
      public function addStack(array $middlewares)
      {
           foreach ($middlewares as $middleware)
           {
               $this->add($middleware);
           }
      }


     /**
      * Run all middlewares
      * @param RequestInterface $request
      * @param ResponseInterface $response
      * @return mixed
      */
      public function handle(RequestInterface $request, ResponseInterface $response)
      {
          return call_user_func_array($this->start, [$request, $response]);
      }
}
