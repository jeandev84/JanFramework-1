<?php
namespace Jan\Foundation\Commands;


use Jan\Component\Console\Command\Command;
use Jan\Component\Console\Input\InputInterface;
use Jan\Component\Console\Output\OutputInterface;



/**
 * Class HelpCommand
 * @package Jan\Foundation\Commands
*/
class HelpCommand extends Command
{

    /** @var string  */
    protected $command = '-help';


    /** @var array  */
    protected $commands = [];


    /**
     * @param array $commands
    */
    public function setCommands(array $commands)
    {
        $this->commands = $commands;
    }


    /**
      * @param InputInterface $input
      * @param OutputInterface $output
      * @return mixed|void
    */
    public function execute(InputInterface $input, OutputInterface $output)
    {
          // Do something
          // dump($this->commands);
          $output->write(__CLASS__);
     }
}