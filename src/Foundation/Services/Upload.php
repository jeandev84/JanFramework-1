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
      public function __construct(array $uploadedFiles)
      {
            $this->uploadedFiles = $uploadedFiles;
      }


      /**
       * @param string $target
       * @param string $filename
       * @return array
      */
      public function move($target, $filename = null)
      {
          $uploaded = [];
          foreach ($this->uploadedFiles as $uploadedFile)
          {
              if(! $uploadedFile instanceof UploadedFile)
              {
                   exit('File is not uploadeable');
              }

              if($uploadedFile->move($target, $filename))
              {
                  $uploaded[] = $filename;
              }
          }

          return $uploaded;
      }
}