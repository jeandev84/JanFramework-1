<?php
namespace Jan\Component\Event\Contract;

use ReflectionClass;



/**
 * Class Event
 * @package Jan\Component\Event\Contract
*/
abstract class Event
{


    /** @return string */
    /* abstract public function getName(); */


    /**
     * @return string
     * @throws \ReflectionException
    */
    public function getName()
    {
        return (new ReflectionClass($this))->getShortName();
    }
}