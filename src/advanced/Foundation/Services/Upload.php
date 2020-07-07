<?php
namespace Jan\Foundation\Services;


use Jan\Component\Http\UploadedFile;


/**
 * Class Upload
 * @package Jan\Foundation\Services
*/
class Upload
{

     /** @var string */
     private $uploadDir;


      /**
       * Upload constructor.
       * @param $uploadDir
      */
      public function __construct(string $uploadDir='')
      {
          $this->uploadDir = $uploadDir;
      }


      /**
       * @param UploadedFile $uploadedFile
       * @return void
      */
      public function move(UploadedFile $uploadedFile)
      {
          $filename = md5($uploadedFile->getFilename()) . '.'. $uploadedFile->getExtension();
          $uploadedFile->move($this->uploadDir, $filename);
      }


      /**
       * @param array $uploadedFiles
      */
      public function moves($uploadedFiles = [])
      {
          foreach ($uploadedFiles as $uploadedFile)
          {
              $this->move($uploadedFile);
          }
      }
}