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
     */
     public function __construct()
     {
         if(php_sapi_name() != 'cli')
         {
             exit('Access denied!');
         }

         $this->loadCommands($this->getDefaultCommands());
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
     */
     public function addCommand(Command $command)
     {
         $this->commands[$command->getName()] = $command;
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
                    // get command help
                    $help = $command->getHelp();

                    if(! $help)
                    {
                        $output->write(sprintf('Can not find help for command %s', $name));
                    }else{
                        $output->write(sprintf('%s : %s', $name, $help));
                    }

                    return $output->send();
               }
          }

          if(! $command instanceof Command)
          {
              $output->write(sprintf('%s is not a valid command!', $name));

          } else {

              $command->execute($input, $output);
              return $output->send();
          }
     }


     public function head()
     {
         //
     }

     public function foot()
     {
          //
     }


     /**
      * @return array
     */
     public function getDefaultCommands()
     {
         return [
             new HelpCommand(),
             new ListCommand()
         ];
     }
}