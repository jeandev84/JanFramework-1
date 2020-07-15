<?php
namespace Jan\Foundation\Commands\Generators;


use Jan\Component\Console\Command\Command;
use Jan\Component\Console\Input\InputInterface;
use Jan\Component\Console\Output\OutputInterface;


/**
 * Class MakeMigrationCommand
 * @package Jan\Foundation\Commands\Generators
*/
class MakeMigrationCommand extends Command
{

    /**
     * @var string
    */
    protected $name = 'make:migration';


    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return mixed|void
    */
    public function execute(InputInterface $input, OutputInterface $output)
    {
         $output->write('Make migration');
    }
}