<?php
namespace Jan\Foundation\Commands\Traits;


use Jan\Component\DI\Contracts\ContainerInterface;
use Jan\Component\FileSystem\FileSystem;


/**
 * Trait Generatable
 * @package Jan\Foundation\Commands\Traits
*/
trait Generatable
{

   /** @var FileSystem  */
   protected $fileSystem;


   /** @var string  */
   protected $stubDirectory = __DIR__ . '/../stubs';



   /**
     * @param $name (filename of stub)
     * @param $replacements
     * @return false|string|string[]
   */
   public function generateStub($name, $replacements)
   {
       return str_replace(
           array_keys($replacements),
           $replacements,
           file_get_contents(sprintf('%s/%s.stub', $this->stubDirectory, $name))
       );
   }
}