<?php
namespace Jan\Foundation;


use Jan\Component\DI\Contracts\ContainerInterface;
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

              return '';
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
        * Run all middlewares
      */
      public function handle(RequestInterface $request, ResponseInterface $response)
      {
          /* return call_user_func($this->start); */
          return call_user_func_array($this->start, [$request, $response]);
      }
}

/*
$middlewareStack = new MiddlewareStack();
$middlewareStack->add(new AuthenticateMiddleware());
$middlewareStack->add(new NoUserMiddleware());

$middlewareStack->handle();
*/