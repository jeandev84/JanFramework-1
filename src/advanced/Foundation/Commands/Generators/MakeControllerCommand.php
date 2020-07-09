<?php
namespace Jan\Foundation\Commands\Generators;


use Jan\Component\Console\Command\Command;
use Jan\Component\Console\Input\InputInterface;
use Jan\Component\Console\Output\OutputInterface;



/**
 * Class MakeControllerCommand
 * @package Jan\Foundation\Commands\Generators
*/
class MakeControllerCommand extends Command
{

    /** @var string  */
    protected $name = 'make:controller';


    /** @var string  */
    protected $description = 'Command make:controller permit to generate a new controller';


    /**
     * @param InputInterface|null $input
     * @param OutputInterface|null $output
     * @return mixed
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
          $output->write('Make controller');
    }
}