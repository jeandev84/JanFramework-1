<?php
namespace Jan\Component\Http\Bag;


/**
 * Class Bag
 * @package Jan\Component\Http\Bag
*/
abstract class Bag
{

    /**
     * @var array
    */
    protected $data = [];


    /**
     * Bag constructor.
     * @param array $data
    */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * @param string $key
     * @return bool
    */
    public function has(string $key)
    {
        return array_key_exists($key, $this->data);
    }


    /**
     * @param string $key
     * @param null $default
     * @return mixed|null
    */
    public function get(string $key, $default = null)
    {
        return $this->has($key) ? $this->data[$key] : $default;
    }
}