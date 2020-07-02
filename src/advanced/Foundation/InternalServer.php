<?php
namespace Jan\Foundation;


/**
 * Class InternalServer
 * @package Jan\Foundation
*/
class InternalServer
{


     public function __construct()
     {
     }

     /**
      * Run internal server
     */
     public function run()
     {
         shell_exec('php -S localhost:8080 -t public -d display_errors=1');
     }
}