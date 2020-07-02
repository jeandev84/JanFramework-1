<?php
namespace Jan\Component\Database\ORM;


use Jan\Component\Database\Manager;

/**
 * Class EntityRepository
 * @package Jan\Component\Database\ORM
*/
class EntityRepository
{
        public function __construct(Manager $manager, $entityClass)
        {
        }


        /**
         * @param $method
         * @param $arguments
         * @return mixed
        */
        public function __call($method, $arguments)
        {
             $recordClass = new ActiveRecord();
             if(method_exists($recordClass, $method))
             {
                  return call_user_func([$recordClass, $method], $arguments);
             }
        }
}