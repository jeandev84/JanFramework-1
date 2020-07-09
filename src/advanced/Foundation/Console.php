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
      * @return Command
     */
     public function getCommand($name): Command
     {
         return $this->commands[$name];
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

          if($this->hasCommand($name))
          {
               $command = $this->getCommand($name);

               if(\ in_array($name, ['-help', '-h']))
               {
                    // $command->setCommands($this->commands);
               }

               $command->execute($input, $output);
          }

          return $output->send();
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