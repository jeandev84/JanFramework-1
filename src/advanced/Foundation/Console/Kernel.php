<?php
namespace Jan\Foundation\Console;


use Jan\Component\Console\Command\Command;
use Jan\Component\Console\Input\InputInterface;
use Jan\Component\Console\Output\OutputInterface;
use Jan\Component\DI\Contracts\ContainerInterface;
use Jan\Component\FileSystem\FileSystem;
use Jan\Contracts\Console\Kernel as ConsoleKernelContract;
use Jan\Foundation\Facades\Console;


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
        'Jan\Foundation\Commands\Generators\MakeControllerCommand',
        'Jan\Foundation\Commands\Generators\MigrateCommand'
    ];


    /**
     * Kernel constructor.
     * @param ContainerInterface $container
    */
    public function __construct(ContainerInterface $container)
    {
         $this->container = $container;
         $this->loadRoutes();
    }


    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return mixed
     * @throws \Exception
    */
    public function handle(InputInterface $input, OutputInterface $output)
    {
         if(php_sapi_name() != 'cli')
         {
             exit('Access denied!');
         }

         Console::instance()->loadCommands(
             $this->bootCommandStuff()
         );

         return Console::instance()->run($input, $output);
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


    private function loadRoutes()
    {
        $this->getFileSystem()->load('/routes/console.php');
    }



    /**
     * @return mixed
     */
    private function getFileSystem()
    {
        return $this->container->get(FileSystem::class);
    }
}