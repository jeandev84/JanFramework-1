<?php
namespace Jan\Component\Event;


use Jan\Component\Event\Contract\Listener;


/**
 * Class Dispatcher
 * @package Jan\Component\Event
 *
 * Event Dispatcher
*/
class Dispatcher
{
    /*
     protected $listeners = [
         'UserSignedUp' => [],
         'UserSignedIn' => []
     ];
    */

     /** @var array  */
     protected $listeners = [];


     /**
      * @return array
     */
     public function getListeners()
     {
          return $this->listeners;
     }


    /**
     * @param $eventName
     * @param Listener $listener
     */
     public function addListener($eventName, Listener $listener)
     {
         $this->listeners[$eventName][] = $listener;
     }


    /**
     * Get listeners by event name
     * @param $eventName
     * @return array|mixed
     */
     public function getListenersByEvent($eventName)
     {
         if(! $this->hasListeners($eventName))
         {
             return [];
         }

         return $this->listeners[$eventName];
     }


    /**
     * @param $eventName
     * @return bool
     */
     public function hasListeners($eventName)
     {
         return isset($this->listeners[$eventName]);
     }

     /**
      * @param Event $event
     */
     public function dispatch(Event $event)
     {
         foreach ($this->getListenersByEvent($event->getName()) as $listener)
         {
              $listener->handle($event);
         }
     }
}