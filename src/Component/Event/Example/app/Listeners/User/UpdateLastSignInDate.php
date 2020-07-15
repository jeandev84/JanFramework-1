<?php
namespace App\Listeners\User;


use App\Core\Events\Event;
use App\Core\Events\Listener;

/**
 * Class UpdateLastSignInDate
 * @package App\Listeners\User
*/
class UpdateLastSignInDate extends Listener
{

    /**
     * @param Event $event
    */
    public function handle(Event $event)
    {
        # echo 'Update record in database with ID of '. $event->user->id;
        echo '<div>Update record in database with ID of '. $event->getUser()->getId().
             '<strong> from '. __METHOD__.'</strong>
             </div>';
    }
}