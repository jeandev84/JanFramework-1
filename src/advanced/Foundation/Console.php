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
      * @var string
     */
     private $defaultCommand = 'list';

     /**
      * @var array
     */
     private $commands = [];


    /**
     * Console constructor.
     * @param Request|null $request
     */
     public function __construct(Request $request = null)
     {
         /*
         if(! $request->isCli())
         {
              die('Access denied');
         }
         */

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
         $this->commands[] = $command;
     }


    /**
     * @param array $commands
    */
    public function addCommands(array $commands)
    {
         foreach ($commands as $command)
         {
              $this->addCommand($command);
         }
    }


    /**
     * @param InputInterface $input
     * @param OutputInterface $output
    */
    public function run(InputInterface $input, OutputInterface $output)
    {
          return 'Console::run';
    }
}