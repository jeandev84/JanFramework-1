<?php
namespace Jan\Component\DI\Contracts;


/**
 * Interface ServiceProviderInterface
 * @package Jan\Component\DI\Contracts
*/
interface ServiceProviderInterface
{
     /**
      * Register service in container
      * @return mixed
     */
     public function register();
}