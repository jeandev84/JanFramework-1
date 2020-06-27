<?php
namespace Jan\Contracts\Http;


use Jan\Component\Http\Contracts\RequestInterface;
use Jan\Component\Http\Contracts\ResponseInterface;


/**
 * Interface Kernel
 * @package Jan\Contracts\Http
*/
interface Kernel
{

     /**
      * @param RequestInterface $request
      * @return ResponseInterface
     */
     public function handle(RequestInterface $request): ResponseInterface;

}