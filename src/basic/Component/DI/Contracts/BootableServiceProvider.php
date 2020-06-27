<?php
namespace Jan\Component\DI\Contracts;


/**
 * Interface BootableServiceProvider
 * @package Jan\Component\DI\Contracts
*/
interface BootableServiceProvider
{

     /**
      * Run before registring
      * @return mixed
     */
     public function boot();
}