<?php
namespace App\Http\Controllers;


use App\Entity\User;
use App\Http\Contracts\Controller;
use Jan\Component\Database\Database;
use Jan\Component\Database\Schema;
use Jan\Component\Database\Table\BluePrint;
use Jan\Component\FileSystem\FileSystem;


/**
 * Class UserController
 * @package App\Http\Controllers
*/
class UserController extends Controller
{

        /**
         * @return \Jan\Component\Http\Response
        */
        public function index(FileSystem $fileSystem)
        {
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


        /**
         * @throws \Exception
        */
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

            Schema::create('users', function (BluePrint $table) {
               $table->increments('id');
               $table->string('username', 200);
               $table->string('password');
               $table->string('role');
               $table->timestamps();
            });
       }

}