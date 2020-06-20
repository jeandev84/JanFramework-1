<?php
namespace App\Http\Controllers;


/**
 * Class UserController
 * @package App\Http\Controllers
*/
class UserController
{

      /**
        * @param string $token
      */
      public function edit(string $token)
      {
           echo __METHOD__ . ' TOKEN : ' . $token;
           echo '<br>';
      }
}