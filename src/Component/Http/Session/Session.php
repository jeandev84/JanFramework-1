<?php
namespace Jan\Component\Http\Session;


/**
 * Class Session
 * @package Jan\Component\Http\Session
*/
class Session
{

     /**
      * @var array
     */
     protected $sessions = [];


     /**
      * Session constructor.
      * @param array $sessions
     */
     public function __construct(array $sessions = [])
     {
         $this->sessions = $sessions ?? $_SESSION;
     }
}