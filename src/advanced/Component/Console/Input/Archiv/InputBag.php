<?php
namespace Jan\Component\Console\Input;


use InvalidArgumentException;

/**
 * Class InputBag
 * @package Jan\Component\Console\Input
*/
class InputBag
{

     /** @var array  */
     private $arguments = [];


     /** @var array  */
     private $options = [];


     /** @var array  */
     private $shortcuts = [];


    /**
     * InputBag constructor.
     * @param array $definition
     */
     public function __construct(array $definition = [])
     {
          $this->setDefinition($definition);
     }


     /**
      * @param array $definition
     */
     public function setDefinition(array $definition)
     {
         $arguments = [];
         $options = [];

         foreach ($definition as $item)
         {
             if($this->isInputOption($item))
             {
                 $options[] = $item;
             }else{
                 $arguments[] = $item;
             }
         }

         $this->setArguments($arguments);
         $this->setOptions($options);
     }


     /**
      * @param array $arguments
     */
     public function setArguments(array $arguments = [])
     {
          $this->arguments = [];
          $this->addArguments($arguments);
     }


     /**
      * Add an array of InputArgument object
      *
      * @param array|null $arguments
     */
     public function addArguments(?array $arguments)
     {
         if($arguments)
         {
             foreach ($arguments as $argument)
             {
                 $this->addArgument($argument);
             }
         }
     }


     /**
      * @param InputArgument $argument
     */
     public function addArgument(InputArgument $argument)
     {
         $this->arguments[$argument->getName()] = $argument;
     }


    /**
     * Returns true if an InputArgument object exists by name or position
     *
     * @param string $name
     * @return bool true if the InputArgument object exists, false otherwise
     */
     public function hasArgument(string $name)
     {
         return isset($this->arguments[$name]);
     }


     /**
      * @param string $name
      * @return mixed
     */
     public function getArgument(string $name)
     {
         if (!$this->hasArgument($name))
         {
            throw new InvalidArgumentException(
                sprintf('The "%s" argument does not exist.', $name)
            );
        }

        return $this->arguments[$name];
     }


     /**
      * @return array
     */
     public function getArguments()
     {
         return $this->arguments;
     }


     /**
      * @param InputOption $option
     */
     public function addOption(InputOption $option)
     {
        $this->options[$option->getName()] = $option;
     }

    /**
     * @param string $name
     * @return bool
     */
    public function hasOption(string $name)
    {
        return isset($this->options[$name]);
    }


    /**
     * @param array $options
    */
    public function setOptions(array $options)
    {
        $this->options = $options;
    }


    /**
     * @param $item
     * @return bool
    */
    protected function isInputOption($item)
    {
        return $item instanceof InputOption;
    }


    /**
     * @param $item
     * @return bool
     */
    protected function isInputArgument($item)
    {
        return $item instanceof InputArgument;
    }

}