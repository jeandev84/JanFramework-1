<?php
namespace Jan\Component\Console\Input;


/**
 * Class InputOption
 * @package Jan\Component\Console\Input
*/
class InputOption
{

    /** @var string  */
    private $name;


    /** @var string|null  */
    private $shortcut;


    /** @var string  */
    private $description;


    /** @var null  */
    private $default;


    /**
     * InputOption constructor.
     * @param string $name
     * @param null $shortcut
     * @param string $description
     * @param null $default
    */
    public function __construct(string $name, $shortcut = null, string $description = '', $default = null)
    {
        $this->name = $name;
        $this->shortcut = $shortcut;
        $this->description = $description;
        $this->default = $default;
    }


    /**
     * @return string
    */
    public function getName()
    {
        return $this->name;
    }


    /**
     * @return null
    */
    public function getShortcut()
    {
        return $this->shortcut;
    }

    /**
     * @return string
    */
    public function getDescription()
    {
        return $this->description;
    }


    /**
     * @return null
    */
    public function getDefault()
    {
        return $this->default;
    }


}