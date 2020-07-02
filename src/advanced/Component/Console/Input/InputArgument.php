<?php
namespace Jan\Component\Console\Input;


/**
 * Class InputArgument
 * @package Jan\Component\Console\Input
 *
 * Input argument entity
*/
class InputArgument
{

    /** @var string  */
    private $name;


    /** @var string  */
    private $description;


    /** @var string  */
    private $default;


    /**
     * InputArgument constructor.
     * @param string $name
     * @param string $description
     * @param string $default
    */
    public function __construct(string $name, string $description = '', $default = '')
    {
        $this->name = $name;
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
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }


    /**
     * @return string|null
    */
    public function getDefault(): ?string
    {
        return $this->default;
    }

    /**
     * @param string|null $default
    */
    public function setDefault(?string $default = null)
    {
        $this->default = $default;
    }

}