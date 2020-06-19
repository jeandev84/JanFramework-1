<?php
namespace Jan\Foundation\Services;


use Jan\Component\Http\UploadedFile;

/**
 * Class Upload
 * @package Jan\Foundation\Services
*/
class Upload
{

      /**
       * @var array
      */
      private $uploadedFiles = [];


      /**
       * Upload constructor.
       * @param array $uploadedFiles
      */
      public function __construct(array $uploadedFiles = [])
      {
            $this->uploadedFiles = $uploadedFiles;
      }


      /**
       * @return Upload
      */
      public function move()
      {
          foreach ($this->uploadedFiles as $uploadedFile)
          {
              if(! $uploadedFile instanceof UploadedFile)
              {
                   exit('File is not uploadeable');
              }

              dump($uploadedFile);
          }

          return $this;
      }
}