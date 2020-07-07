<?php
namespace Jan\Component\Http;


use Jan\Component\Http\Contracts\MiddlewareInterface;
use Jan\Component\Http\Contracts\RequestInterface;



/**
 * Class Middleware
 * @package Jan\Component\Http
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
          $this->start = function (RequestInterface $request) {
              return true; /* new Response(); */
          };
      }


      /**
       * @param MiddlewareInterface $middleware
       * @return Middleware
      */
      public function add(MiddlewareInterface $middleware)
      {
          $next = $this->start;

          $this->start = function (RequestInterface $request) use ($middleware, $next) {

                return $middleware->__invoke($request, $next);
          };

          return $this;
      }


      /**
        * @param array $middlewares
      */
      public function stack(array $middlewares)
      {
           foreach ($middlewares as $middleware)
           {
               $this->add($middleware);
           }
      }


      /**
       * Middleware handle
       *
       * @param RequestInterface $request
       * @return mixed
      */
      public function handle(RequestInterface $request)
      {
          return call_user_func($this->start, $request);
      }
}
