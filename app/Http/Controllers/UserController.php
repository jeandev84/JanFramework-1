<?php
namespace App\Http\Controllers;


use App\Entity\User;
use App\Http\Contracts\Controller;
use Jan\Component\Database\Database;
use Jan\Component\Database\Schema;
use Jan\Component\Database\Table\BluePrint;


/**
 * Class UserController
 * @package App\Http\Controllers
*/
class UserController extends Controller
{

        /**
         * @return \Jan\Component\Http\Response
        */
        public function index()
        {
            Schema::create('users', function (BluePrint $table) {
                $table->increments('id');
                $table->string('username');
                $table->string('password');
                $table->string('role');
            });

            return $this->render('users/index');
        }


        /**
         * @param string $token
         * @return \Jan\Component\Http\Response
        */
        public function edit(string $token)
        {
           return $this->render('users/edit', compact('token'));
        }


       public function demo()
       {
            // Database::connect([]);
            // dump(Database::pdo()->execute('SELECT * FROM users', [], User::class)->get());
            // Database::disconnect();

            // dd(Database::pdo());
            // dump(Database::getConnection());
            // dd(password_hash('yurev085', PASSWORD_BCRYPT));
            //dd(User::findAll()->get());

            /*
            $user = new User();
            $user->id = 2;
            $user->email = 'demo@site.com';
            $user->password = password_hash('yurev085', PASSWORD_BCRYPT);
            dd($user);
            */
     }

}