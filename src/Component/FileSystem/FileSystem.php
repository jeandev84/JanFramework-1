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
          return $this->details($path, 'filename');
       }


        /**
         * @param string $path
         * @return string
        */
        public function extension(string $path)
        {
            return $this->details($path, 'extension');
        }



        /**
         * @param string $path
         * @param string $context
         * @return string|string[]
        */
        public function details(string $path, $context = null)
        {
            $details = pathinfo($this->resource($path));
            return $details[$context] ?? $details;
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
           $dirname = dirname($filename);
           $target = $this->mkdir($dirname);
           $filename = $this->resource($filename);
           return $target ? (touch($filename) ? $filename : false) : false;
        }
}

/*
$fileSystem = new FileSystem($container->get('base.path'));
echo $fileSystem->resource('config/app.php');
$files = $fileSystem->resources('/config/*.php');
$config = $fileSystem->load('config/app.php');
$fileSystem->mkdir('storage/cache');

$fileSystem->make('app/Http/Controllers/TestController.php');
$fileSystem->make('database/migrations/2020_06_25_users_table.php');
$fileSystem->make('.env');
$fileSystem->make('bootstrap/cache/.gitignore');
$fileSystem->details('config/app.php')
*/