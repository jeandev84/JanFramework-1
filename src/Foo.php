<?php
namespace Jan;


/**
 * Class Foo
 * @package Jan
*/
class Foo
{

     /**
      * Foo constructor.
      * @param Bar $bar
      * @param int $id
      * @param string $slug
     */
      public function __construct(Bar $bar, $id, $slug)
      {
          echo __METHOD__;
      }
}