<?php
namespace Jan\Foundation;


use Jan\Component\Console\Command\Command;
use Jan\Component\Console\Input\InputInterface;
use Jan\Component\Console\Output\OutputInterface;
use Jan\Component\Http\Request;
use Jan\Foundation\Commands\HelpCommand;
use Jan\Foundation\Commands\ListCommand;


/**
 * Class Console
 * @package Jan\Foundation
*/
class Console
{

     const MSG_NOT_HELP = 'Can not find help for command %s';
     const MSG_NOT_VALID_CMD = '%s is not a valid command!';


     /**
      * @var array
     */
     private $commands = [];


     /** @var string  */
     private $defaultCommand = 'list';


     /** @var string  */
     private $helpCommand = '-help';


     /**
      * Console constructor.
      * @param bool $condition
     */
     public function __construct(bool $condition = false)
     {
         if($condition === true)
         {
             exit('Access denied!');
         }

         $this->loadBaseCommands();
     }


    /**
     * @param array $commands
    */
    public function loadCommands(array $commands)
    {
        foreach ($commands as $command)
        {
            $this->addCommand($command);
        }
    }


     /**
      * @param Command $command
      * @return Console
     */
     public function addCommand(Command $command)
     {
         return $this->add($command->getName(), $command);
     }


     /**
      * @param $name
      * @param Command $command
      * @return Console
     */
     public function add($name, Command $command)
     {
         $this->commands[$name] = $command;

         return $this;
     }


     /**
      * @param $name
      * @return bool
     */
     public function hasCommand($name)
     {
         return array_key_exists($name, $this->commands);
     }


     /**
      * @param $name
      * @return null|Command
     */
     public function getCommand($name): ?Command
     {
         return $this->commands[$name] ?? null;
     }


     /**
      * @param InputInterface $input
      * @param OutputInterface $output
      * @return string
      * @throws \Exception
     */
     public function run(InputInterface $input, OutputInterface $output)
     {
          $name = $input->getFirstArgument();
          $argument = $input->getArgument();
          $command = null;

          if(! $name)
          {
             $name = $this->defaultCommand;
          }

          if(\ in_array($name, ['-help', '-h']))
          {
              $name = $this->helpCommand;
          }

          if($this->hasCommand($name))
          {
               $command = $this->getCommand($name);

               if(method_exists($command, 'setCommands'))
               {
                   $command->setCommands($this->commands);
               }

               if(in_array($argument, ['-help', '-h']))
               {
                    $help = $command->getHelp();
                    $message = ! $help ? sprintf(self::MSG_NOT_HELP, $name) : sprintf('%s : %s', $name, $help);
                    $output->write($message);
                    return $output->send();
               }
          }

          if(! $this->isSureCommand($command))
          {
              $output->write(sprintf(self::MSG_NOT_VALID_CMD, $name));
          } else {
              $command->execute($input, $output);
          }

          return $output->send();
     }


     /**
      * @param $command
      * @return bool
     */
     private function isSureCommand($command)
     {
         return $command instanceof Command;
     }

     /**
      * @return
     */
     public function loadBaseCommands()
     {
         $this->loadCommands([
             new HelpCommand(),
             new ListCommand()
         ]);
     }


    public function buildHeader()
    {
        //
    }

    public function buildFooter()
    {
        //
    }
}