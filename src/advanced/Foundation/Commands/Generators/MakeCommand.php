<?php
namespace Jan\Foundation\Commands\Generators;


use Jan\Component\Console\Command\Command;
use Jan\Component\Console\Input\InputInterface;
use Jan\Component\Console\Output\OutputInterface;
use Jan\Component\DI\Contracts\ContainerInterface;
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
        $commandClass = $input->getArgument();

        $stub = $this->generateStub('command', [
            'CommandClass' => $commandClass,
            'CommandNamespace' => 'App\Commands'
        ]);

        $target = sprintf('app/Commands/%s.php', $input->getArgument());

        if($this->fileSystem->exists($target))
        {
            $output->write('Command already exist!');
            return;
        }

        $this->fileSystem->write($target, $stub);

        $output->write('Command generated successfully!');
    }
}