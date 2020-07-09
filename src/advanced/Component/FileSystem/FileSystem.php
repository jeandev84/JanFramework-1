<?php
namespace Jan\Component\FileSystem;


use Exception;
use Jan\Component\FileSystem\Exceptions\FileSystemException;

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
       *
       * Example:
       *  $filesystem = new FileSytem(__DIR__.'/../')
       *
       * @param string $root
       * @throws FileSystemException
       *
      */
      public function __construct(string $root)
      {
           if(! is_dir($root))
           {
               throw new FileSystemException(
                   sprintf('%s is not a directory', $root)
               );
           }

           $this->root($root);
      }


      /**
       * @param string $root
       * @return FileSystem
      */
      public function root(string $root)
      {
          $this->root = rtrim($root, '/');

          return $this;
      }



      /**
       * @param string $path
       * @return string
       *
       * $this->resource('config/app.php)
      */
      public function resource(string $path)
      {
          return implode([
              $this->root,
              DIRECTORY_SEPARATOR,
              $this->preparePath($path)
          ]);

          /*
          return rtrim($this->root, '/') . DIRECTORY_SEPARATOR. $this->preparePath($path);
          */
      }


     /**
      * @param string $path
      * @return string|string[]
     */
      private function preparePath(string $path)
      {
          return str_replace('/', DIRECTORY_SEPARATOR, trim($path, '/'));
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
       * @return string
      */
      public function basename(string $path)
      {
           return basename($this->resource($path));
      }


      /**
        * @param string $path
        * @return string
       */
       public function dirname(string $path)
       {
          return dirname($this->resource($path));
       }


       /**
        * @param string $path
        * @return string
       */
       public function nameOnly(string $path)
       {
          return $this->info($path, 'filename');
       }


        /**
         * @param string $path
         * @return string
        */
        public function extension(string $path)
        {
            return $this->info($path, 'extension');
        }



        /**
         * @param string $path
         * @param string $context
         * @return string|string[]
        */
        public function info(string $path, $context = null)
        {
            $info = pathinfo($this->resource($path));
            return $info[$context] ?? $info;
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

            if(! is_dir($target))
            {
               mkdir($target, 0777, true);
            }

            return $target;
        }


        /**
         * @param string $filename
         * @return bool
        */
        public function make(string $filename)
        {
           $target = $this->mkdir(dirname($filename));
           $filename = $this->resource($filename);
           return $target ? (touch($filename) ? $filename : false) : false;
        }



        /**
         * Read file
         *
         * @param string $path
         * @return false|string
        */
        public function read(string $path)
        {
            return file_get_contents($this->resource($path));
        }


        /**
         * Put content into file
         *
         * @param string $path
         * @param $data
        */
        public function write(string $path, $data)
        {
            return file_put_contents($this->resource($path), $data);
        }


        /**
         * Upload file
         *
         * @param $target
         * @param $filename
        */
        public function move($target, $filename)
        {
            move_uploaded_file($this->mkdir($target), $filename);
        }


        /**
         * @param $source
         * @param $destination
        */
        public function copy($source, $destination)
        {
             copy($source, $destination);
        }
}

/*
$fileSystem = new FileSystem($container->get('base.path'));
+echo $fileSystem->resource('config/app.php');
$files = $fileSystem->resources('/config/*.php');
$config = $fileSystem->load('config/app.php');
$fileSystem->mkdir('storage/cache');

$fileSystem->make('app/Http/Controllers/TestController.php');
$fileSystem->make('database/migrations/2020_06_25_users_table.php');
$fileSystem->make('.env');
$fileSystem->make('bootstrap/cache/.gitignore');
$fileSystem->info('config/app.php')
*/