<?php
namespace App\Listeners\User;


use App\Core\Events\Event;
use App\Core\Events\Listener;

/**
 * Class SendSigninEmail
 * @package App\Listeners\User
*/
class SendSigninEmail extends Listener
{
   /**
     * SendSigninEmail constructor.
   */
   /* public function __construct(SomeClassInject $classInject) { } */


    /**
     * @param Event $event
    */
    public function handle(Event $event)
    {
        # echo 'Send sign in email to '. $event->user->email;
        echo '<div>Send sign in email to '. $event->getUser()->getEmail() .
             '<strong> from '. __METHOD__.'</strong>
             </div>';
    }
}