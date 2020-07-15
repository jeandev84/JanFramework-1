<?php
namespace Jan\Foundation\Commands;


use Jan\Component\Console\Command\Command;
use Jan\Component\Console\Input\InputInterface;
use Jan\Component\Console\Output\OutputInterface;


/**
 * Class ListCommand
 * @package Jan\Foundation\Commands
*/
class ListCommand extends Command
{

    /** @var string  */
    protected $command = 'list';


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
     * @param InputInterface|null $input
     * @param OutputInterface|null $output
     * @return mixed
    */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $output->write($this->getCommandList());
    }


    /**
     * @return string
    */
    private function getCommandList()
    {
        $str = "Available commands list : \n";
        foreach ($this->commands as $name => $command)
        {
           if(! \in_array($name, ['-help', 'list']))
           {
               $str .= sprintf("%s \n- %s \n", $name, $command->getDescription());
           }
        }

        return $str;
    }
}