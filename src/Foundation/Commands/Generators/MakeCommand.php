<?php
namespace Jan\Foundation\Commands\Generators;


use Jan\Component\Console\Command\Command;
use Jan\Component\Console\Input\InputInterface;
use Jan\Component\Console\Output\OutputInterface;
use Jan\Component\FileSystem\FileSystem;
use Jan\Foundation\Commands\Traits\Generatable;



/**
 * Class MakeCommand
 * @package Jan\Foundation\Commands
*/
class MakeCommand extends Command
{

    use Generatable;


    /** @var string  */
    protected $name = 'make:command';


    /** @var string  */
    protected $description = 'Generate a new command';


    /** @var FileSystem */
    protected $fileSystem;


    /**
     * MakeCommand constructor.
     * @param FileSystem $fileSystem
    */
    public function __construct(FileSystem $fileSystem)
    {
        parent::__construct();
        $this->fileSystem = $fileSystem;
    }



    /**
     * @param InputInterface|null $input
     * @param OutputInterface|null $output
     * @return mixed
    */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $commandName = $input->getArgument();

        if(! $commandName)
        {
            $output->write('Empty argument command class');
            return;
        }

        if(strpos($commandName, ':') === false)
        {
               $output->write('Invalid command name!');
               return;
        }

        $parts = explode(':', $commandName);
        $commandClass = sprintf('%sCommand', ucfirst($parts[0]) . ucfirst($parts[1]));

        $stub = $this->generateStub('command', [
            'CommandClass' => $commandClass,
            'CommandNamespace' => 'App\Commands',
            'commandName' => $commandName
        ]);

        $target = sprintf('app/Commands/%s.php', $commandClass);

        if($this->fileSystem->exists($target))
        {
            $output->write('Command  '. $commandClass . ' already exist!');
            return;
        }

        if($this->fileSystem->write($target, $stub))
        {
            $output->write(
                sprintf('Command %s generated successfully!', $target)
            );
        }
    }
}