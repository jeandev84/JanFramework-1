<?php
namespace Jan\Foundation\Routing;


use Jan\Component\DI\Contracts\ContainerInterface;

/**
 * Trait ControllerTrait
 * @package Jan\Foundation\Routing
*/
trait ControllerTrait
{

     /**
      * @var ContainerInterface
     */
     protected $container;


     /**
      * @param ContainerInterface $container
     */
     public function setContainer(ContainerInterface  $container)
     {
           $this->container = $container;
     }


     /**
      * @return ContainerInterface
     */
     public function getContainer(): ContainerInterface
     {
         return $this->container;
     }
}