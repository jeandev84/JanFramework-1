<?php
namespace Jan\Component\Http\Contracts;

/**
 * Class MiddlewareInterface
 * @package Jan\Component\Http\Contracts
*/
interface MiddlewareInterface
{
     /**
      * @param RequestInterface $request
      * @param ResponseInterface $response
      * @param callable $next
     */
     public function __invoke(RequestInterface $request, ResponseInterface $response, callable $next);
}