<?php
namespace Jan\Foundation;


use Jan\Component\Console\Command\Command;
use Jan\Component\Console\Input\InputInterface;
use Jan\Component\Console\Output\OutputInterface;
use Jan\Component\Http\Request;


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
     }


     /**
      * @param Command $command
     */
     public function addCommand(Command $command)
     {
         $this->commands[$command->getName()] = $command;
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
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return string
    */
    public function run(InputInterface $input, OutputInterface $output)
    {
          return 'Console::run';
    }
}