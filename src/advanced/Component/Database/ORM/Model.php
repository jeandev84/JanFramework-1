<?php
namespace Jan\Component\Database\ORM;

use Jan\Component\Database\Record;


/**
 * Class Model
 * @package Jan\Component\Database\ORM
*/
class Model extends Record implements \ArrayAccess
{

    /**
     * @param mixed $offset
     * @return bool
     */
    public function offsetExists($offset)
    {
        return $this->hasAttribute($offset);
    }



    /**
     * @param mixed $offset
     * @return mixed
    */
    public function offsetGet($offset)
    {
         return $this->getAttribute($offset);
    }



    /**
     * @param mixed $offset
     * @param mixed $value
    */
    public function offsetSet($offset, $value)
    {
         $this->setAttribute($offset, $value);
    }



    /**
     * @param mixed $offset
    */
    public function offsetUnset($offset)
    {
        unset($this->attributes[$offset]);
    }
}