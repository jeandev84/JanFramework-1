<?php
namespace Jan\Foundation\Services;


use Jan\Component\Console\Output\OutputInterface;
use Jan\Component\FileSystem\FileSystem;
use Jan\Foundation\Commands\Traits\Generatable;


/**
 * Class StubGenerator
 * @package Jan\Foundation\Services
*/
class StubGenerator
{

     use Generatable;


     /** @var FileSystem */
     protected $fileSystem;


     /**
      * StubGenerator constructor.
      * @param FileSystem $fileSystem
     */
     public function __construct(FileSystem $fileSystem)
     {
         $this->fileSystem = $fileSystem;
     }

     /**
      * @param $input
      * @param OutputInterface $output
      * @param string $message
     */
     public function generate($input, OutputInterface $output, $message = '')
     {
         if(! $input)
         {
             $output->write($message);
             return;
         }
     }
}