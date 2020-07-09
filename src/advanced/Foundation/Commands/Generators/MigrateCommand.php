<?php
namespace Jan\Foundation\Commands\Generators;


use Jan\Component\Console\Command\Command;
use Jan\Component\Console\Input\InputInterface;
use Jan\Component\Console\Output\OutputInterface;


/**
 * Class MigrateCommand
 * @package Jan\Foundation\Commands\Generators
*/
class MigrateCommand extends Command
{

    /** @var string  */
    protected $name = 'make:migrate';


    /** @var string  */
    protected $description = 'Permit to migrate all tables to the databases.';

    /**
     * @param InputInterface|null $input
     * @param OutputInterface|null $output
     * @return mixed|void
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
         $output->write('Migrations all tables successfully!');
    }
}