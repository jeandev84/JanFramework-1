<?php
namespace Jan\Component\Debug;


use Exception;

/**
 * Class ErrorHandler
 * @package Jan\Component\Debug
*/
class ErrorHandler
{

     /** @var Exception */
     protected $exception;


     /**
      * ErrorHandler constructor.
      * @param Exception $exception
     */
     public function __construct(Exception $exception)
     {
          $this->exception = $exception;
     }


     /** @return mixed */
     public function handle() { }



     /** Log errors for development */
     public function log()
     {
         // error_log('');
     }

}