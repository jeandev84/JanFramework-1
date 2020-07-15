<?php
namespace Jan\Component\Http\Contracts;


/**
 * Class MiddlewareInterface < beetwen request and response >
 * @package Jan\Component\Http\Contracts
*/
interface MiddlewareInterface
{
     /**
      * @param RequestInterface $request
      * @param callable $next
     */
     public function __invoke(RequestInterface $request, callable $next);
}