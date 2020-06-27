<?php
namespace Jan\Component\Console\Input;


use InvalidArgumentException;

/**
 * Class Input
 * @package Jan\Component\Console\Input
*/
abstract class Input implements InputInterface
{

    /** @var  [ for stream ] */
    // protected $stream;


    /** @var bool  */
    protected $interactive = true;


    /** @var  */
    protected $inputBag;


    /** @var array  */
    protected $arguments = [];


    /** @var array  */
    protected $options = [];


    /** @var array  */
    // protected $shortcuts = [];


    /**
     * Input constructor.
     * @param InputBag|null $inputBag
    */
    public function __construct(InputBag $inputBag = null)
    {
           if(! $inputBag)
           {
               $this->inputBag = new InputBag();
           }else{
               $this->initialize($inputBag);
               $this->validate();
           }
    }


    /**
     * @param InputBag $inputBag
    */
    public function initialize(InputBag $inputBag)
    {
          $this->arguments = [];
          $this->options = [];
          $this->inputBag = $inputBag;

          $this->process();
    }


    /**
     * @return bool
    */
    public function isInteractive()
    {
        return $this->interactive;
    }


    /**
     * @param string $name
     * @return mixed|null
    */
    public function getArgument(string $name)
    {
        if(! $this->inputBag->hasArgument($name))
        {
            throw new InvalidArgumentException(
                sprintf('The %s argument does not exist.', $name)
            );
        }

        $default = $this->inputBag->getArgument($name)->getDefault();
        return $this->arguments[$name] ?? $default;
    }


    /**
     * @param string $name
     * @param $value
    */
    public function setArgument(string $name, $value)
    {
         if(! $this->inputBag->hasArgument($name))
         {
             throw new InvalidArgumentException(
                 sprintf('The "%s" argument does not exist.', $name)
             );
         }

         $this->arguments[$name] = $value;
    }


    /**
     * @param string $name
     * @return bool
    */
    public function hasArgument(string $name)
    {
        return $this->inputBag->hasArgument($name);
    }



    /**
     * @return mixed
    */
    public function validate()
    {
        // TODO: Implement validate() method.
    }

    /**
     * @param string $name
     * @return mixed
     */
    public function hasParameterOption(string $name)
    {
        // TODO: Implement hasParameterOption() method.
    }

    /**
     * @param string $name
     * @return mixed
     */
    public function getParameterOption(string $name)
    {
        // TODO: Implement getParameterOption() method.
    }

    /**
     * @return mixed
     */
    public function getArguments()
    {
         return $this->inputBag->getArguments();
    }


    /**
     * @return mixed
    */
    abstract public function process();
}