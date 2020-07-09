<?php
namespace Jan\Component\Console\Command;


use InvalidArgumentException;
use Jan\Component\Console\Input\InputInterface;
use Jan\Component\Console\Output\OutputInterface;
// use Jan\Component\Console\Input\InputArgument;
// use Jan\Component\Console\Input\InputBag;
// use Jan\Component\Console\Input\InputOption;


/**
 * Class Command
 * @package Jan\Component\Console\Command
 *
 * Command handle
*/
class Command implements CommandInterface
{

       /** @var string  */
       protected $command = 'default';


       /** @var string */
       protected $name;


       /** @var string */
       protected $description = '';


       /** @var string  */
       protected $help = '';


       /** @var array  */
       protected $arguments = [];


       /** @var array  */
       protected $options = [];


       /**
        * Configuration command
       */
       protected function configure() {}



       /**
        * Command constructor.
       */
       public function __construct()
       {
            $this->configure();
       }


       /**
        * @param string $name
        * @return Command
       */
       public function setName(string $name)
       {
           // $this->makeSureValidName($name);
           $this->name = $name;

           return $this;
       }


      /**
        * @return string
      */
      public function getName()
      {
           if(! $this->name)
           {
               return $this->command;
           }

           return $this->name;
      }


    /**
     * @param string $description
     * @return Command
    */
    public function setDescription(string $description)
    {
        $this->description = $description;

        return $this;
    }


    /**
     * @return string
    */
    public function getDescription()
    {
        return $this->description;
    }


    /**
     * @param string $help
     * @return $this
    */
    public function setHelp(string $help)
    {
        $this->help = $help;

        return $this;
    }


    /**
     * @return string
    */
    public function getHelp()
    {
        return $this->help;
    }


    /**
     * @param string $name
     * @param string $description
     * @param null $default
     * @return Command
    */
    public function addArgument(string $name, string $description = '', $default = null)
    {
        $this->arguments = compact('name', 'description', 'default');
        return $this;
    }


    /**
     * @param string $name
     * @param null $shortcut
     * @param string $description
     * @param null $default
     * @return Command
    */
    public function addOption(string $name, $shortcut = null, string $description = '', $default = null)
    {
        $this->options = compact('name', 'shortcut', 'description', 'default');
        return $this;
    }


     /**
       * Make sure has valid command name.
       *
       * It must be non-empty and parts can optionally be separated by ":".
       *
       * @param string $name
       * @throws InvalidArgumentException When the name is invalid
    */
     protected function makeSureValidName(string $name = null)
     {
         $name = trim($this->name);
         /*
          Reference to do more sure and advanced
          $params = [];

          foreach ($argv as $argument)
          {
            preg_match('/^-(.+)=(.+)$/', $argument, $matches);

            if (! empty($matches))
            {
                $paramName = $matches[1];
                $paramValue = $matches[2];

                $params[$paramName] = $paramValue;
            }
        }

        if (!preg_match('/^[^\:]++(\:[^\:]++)*$/', $name))
        {
            throw new InvalidArgumentException(
               sprintf('Command name "%s" is invalid.', $name)
            );
        }
       */

      }


      /**
       * @param InputInterface|null $input
       * @param OutputInterface|null $output
       * @return mixed|void
       * @throws \Exception
      */
      public function execute(InputInterface $input, OutputInterface $output)
      {
           throw new \Exception('Command must be executed!');
      }
}