<?php
namespace Jan\Foundation\Commands\Generators;


use Jan\Component\Console\Command\Command;
use Jan\Component\Console\Input\InputInterface;
use Jan\Component\Console\Output\OutputInterface;
use Jan\Component\FileSystem\FileSystem;
use Jan\Foundation\Commands\Traits\Generatable;


/**
 * Class MakeControllerCommand
 * @package Jan\Foundation\Commands\Generators
*/
class MakeControllerCommand extends Command
{

    use Generatable;


    /** @var string  */
    protected $name = 'make:controller';


    /** @var string  */
    protected $description = 'Generate a new controller';


    /**
     * @var FileSystem
    */
    private $fileSystem;


    /**
     * MakeControllerCommand constructor.
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
        $controllerName = $input->getArgument();

        if(! $controllerName)
        {
            $output->write('Empty argument controller name');
            return;
        }

        $stub = $this->generateStub('controller', [
           'ControllerClass' => $controllerName,
           'ControllerNamespace' => 'App\Http\Controllers'
        ]);

        $target = sprintf('app/Http/Controllers/%s.php', $controllerName);

        if($this->fileSystem->exists($target))
        {
            $output->write('Controller '. $controllerName .' already exist!');
            return;
        }

        if($this->fileSystem->write($target, $stub))
        {
            $output->write(
                sprintf('Controller %s generated successfully!', $target)
            );
        }
    }
}