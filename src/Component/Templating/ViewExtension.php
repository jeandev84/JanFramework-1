<?php
namespace Jan\Component\Templating;


/**
 * Class ViewExtension
 * @package Jan\Component\Templating
*/
abstract class ViewExtension
{
    /**
     * Get extension
     * @return mixed
    */
    abstract public function getExtension();


    /**
     * Get function
     *
     * @return mixed
    */
    abstract public function getFunction();
}