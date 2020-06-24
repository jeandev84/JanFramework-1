<?php
namespace Jan\Component\FileSystem;


/**
 * Class FileSystem
 * @package Jan\Component\FileSystem
*/
class FileSystem
{

      /**
       * @var string
      */
      protected $root;


     /**
      * FileSystem constructor.
      * @param string $root
      */
      public function __construct(string $root)
      {
           $this->root = $root;
      }


      /**
       * @param string $path
       * @return string
      */
      public function resource(string $path)
      {
          $path = str_replace('/', DIRECTORY_SEPARATOR, trim($path, '/'));
          return rtrim($this->root, '/') . DIRECTORY_SEPARATOR. $path;
      }


     /**
      * @param string $source
      * @return array|false
      *
      * $this->resources('routes/*')
      * $this->resources('routes/*.php')
      */
      public function resources(string $source)
      {
          return glob($this->resource($source));
      }



      /**
       * @param string $path
       * @return false|string
      */
      public function realPath(string $path)
      {
          return realpath($this->resource($path));
      }


      /**
       * @param string $path
       * @return string|string[]
      */
      public function pathinfo(string $path)
      {
          return pathinfo($path);
      }

      /**
       * @param string $filename
       * @return bool
      */
      public function exists(string $filename)
      {
           return file_exists($this->resource($filename));
      }


      /**
       * @param string $filename
       * @return bool
      */
      public function load(string $filename)
      {
            if(! $this->exists($filename))
            {
                return false;
            }

            return require $this->resource($filename);
      }


      /**
       * @param string $target
       * @return string
      */
      public function mkdir(string $target)
      {
           $target = $this->resource($target);

           if(! is_dir($target) && mkdir($target, 0777, true))
           {
               return true;
           }

           return false;
      }


      /**
        * @param string $filename
      */
      public function make(string $filename)
      {
           dd(pathinfo($filename));
      }
}