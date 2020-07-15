<?php
namespace Jan\Component\Event\Contract;


/**
 * Class Listener
 * @package Jan\Component\Event\Contract
*/
abstract class Listener
{
   /** @param Event $event */
   abstract public function handle(Event $event);
}