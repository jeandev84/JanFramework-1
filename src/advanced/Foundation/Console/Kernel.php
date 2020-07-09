<?php
namespace Jan\Foundation\Console;


use Jan\App;
use Jan\Component\Console\Command\Command;
use Jan\Component\Console\Input\InputInterface;
use Jan\Component\Console\Output\OutputInterface;
use Jan\Component\DI\Contracts\ContainerInterface;
use Jan\Contracts\Console\Kernel as ConsoleKernelContract;
use Jan\Foundation\Console;


/**
 * Class Kernel
 * @package Jan\Foundation\Console
*/
class Kernel implements ConsoleKernelContract
{

    /**
     * @var ContainerInterface
    */
    protected $container;


    /**
     * Default commands
     *
     * @var array
    */
    protected $commands = [];


    /**
     * @var string[]
    */
    protected $defaultCommands = [
        'Jan\Foundation\Commands\Generators\MakeCommand',
        'Jan\Foundation\Commands\Generators\MakeControllerCommand'
    ];


    /**
     * Kernel constructor.
     * @param ContainerInterface $container
    */
    public function __construct(ContainerInterface $container)
    {
         $this->container = $container;
    }


    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return mixed
     * @throws \Exception
    */
    public function handle(InputInterface $input, OutputInterface $output)
    {
         $console = new Console();
         $console->loadCommands(
             $this->bootCommandStuff()
         );
         return $console->run($input, $output);
    }


    /**
     * @param InputInterface $input
     * @param $status
     * @return mixed
     */
    public function terminate(InputInterface $input, $status)
    {
         //
    }



    /**
     * @return array
     */
    protected function bootCommandStuff()
    {
        $resolved = [];

        foreach ($this->getCommands() as $command)
        {
            if($this->isCommand($command))
            {
                $resolved[] = $command;
            }else{
                $resolved[] = $this->container->get($command);
            }
        }

        return $resolved;
    }


    /**
     * @return array
     */
    private function getCommands()
    {
        return array_merge($this->defaultCommands, $this->commands);
    }

    /**
     * @param $command
     * @return bool
    */
    private function isCommand($command)
    {
        return $command instanceof Command;
    }
}