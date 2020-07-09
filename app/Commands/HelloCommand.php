<?php
namespace App\Commands;


use Jan\Component\Console\Command\Command;
use Jan\Component\Console\Input\InputInterface;
use Jan\Component\Console\Output\OutputInterface;


/**
 * Class HelloCommand
 * @package App\Commands
*/
class HelloCommand extends Command
{


    /** @var string  */
    protected $name = 'hello';


    /**
     * Configure command
     */
    public function configure()
    {
        //
    }


    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return mixed|void
    */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        echo $input->getArgument() . "\n";
        echo $input->getArgument('-model') . "\n";
        $output->writeln('Привет! как дела ?');
    }
}