<?php
namespace Jan\Foundation;


use Exception;
use Jan\Component\DI\Contracts\ContainerInterface;

/**
 * Class Loader
 * @package Jan\Foundation
*/
class Loader
{

      /** @var ContainerInterface  */
      protected $container;


      /** @var array  */
      protected $calls = [];


      /** @var array  */
      protected $controllers = [];


     /**
      * Loader constructor.
      * @param ContainerInterface $container
     */
     public function __construct(ContainerInterface $container)
     {
          $this->container = $container;
     }


    /**
     * @param $controller
     * @param $action
     * @param array $params
     * @return mixed
     * @throws Exception
     */
     public function callAction($controller, $action, $params = [])
     {
         return $this->call([$controller, $action], $params);
     }


     /**
      * @param $target
      * @param array $params
      * @return mixed
      * @throws Exception
     */
     public function call($target, $params = [])
     {
          if(! is_callable($target))
          {
               throw new Exception('No callable target');
          }

          return call_user_func_array($target, $params);
     }


     /**
      * @param $controller
      * @return bool
     */
     private function hasController($controller)
     {
         return array_key_exists($controller, $this->controllers);
     }


     /**
      * @param $controller
      * @return mixed
     */
     private function getController($controller)
     {
         return $this->controllers[$controller];
     }


     /**
      * @param $controller
     */
     private function getControllerName($controller)
     {

     }
}