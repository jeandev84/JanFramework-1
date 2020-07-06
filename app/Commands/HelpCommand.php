<?php
namespace App\Commands;


use Jan\Component\Console\Command\Command;
use Jan\Component\Console\Input\InputInterface;
use Jan\Component\Console\Output\OutputInterface;



/**
 * Class HelpCommand
 * @package App\Commands
*/
class HelpCommand extends Command
{

     /**
      * Command configuration
     */
     protected function configure()
     {
          // Add some configuration
     }


     /**
      * @param InputInterface $input
      * @param OutputInterface $output
      * @return mixed|void
     */
     public function execute(InputInterface $input, OutputInterface $output)
     {
          // Do something
     }
}