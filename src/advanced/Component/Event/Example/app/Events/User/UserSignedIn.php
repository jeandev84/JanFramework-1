<?php
namespace App\Events\User;


use App\Core\Events\Event;
use App\Models\Book;

/**
 * Class UserSignedIn
 * @package App\Events\User
*/
class UserSignedIn extends Event
{

    /** @var Book  */
    private $user;


    /**
     * UserSignedIn constructor.
     * @param Book $user
    */
    public function __construct(Book $user)
    {
         $this->user = $user;
    }


    /**
     * @return Book
    */
    public function getUser()
    {
        return $this->user;
    }
}