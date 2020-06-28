<?php
namespace App\Http\Controllers;


use App\Http\Contracts\Controller;
use Jan\Component\Database\Database;
use PDO;

/**
 * Class UserController
 * @package App\Http\Controllers
*/
class UserController extends Controller
{

      /**
       * @param string $token
       * @return \Jan\Component\Http\Response
      */
      public function edit(string $token)
      {
           return $this->render('users/edit', compact('token'));
      }
}