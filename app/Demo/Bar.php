<?php
namespace App\Demo;


/**
 * Class Bar
 * @package App\Demo
*/
class Bar
{
     /**
      * Bar constructor.
      * @param FooInterface $foo
     */
     public function __construct(FooInterface $foo)
     {
         //dd($foo);
     }
}