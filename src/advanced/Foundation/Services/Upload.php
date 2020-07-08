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
          if($uploadDir)
          {
              $this->uploadDir = $uploadDir;
          }

          $this->uploadDir = str_replace('src/advanced/Foundation/Services', '', __DIR__);
          $this->uploadDir .= 'public/uploads/';
      }


      /**
       * @param $uploadedFile
       * @return void
      */
      public function move(UploadedFile $uploadedFile)
      {
          $filename = md5($uploadedFile->getFilename());
          $uploadedFile->move($this->uploadDir, $filename);
      }


      /**
       * @param array $uploadedFiles
      */
      public function upload($uploadedFiles)
      {
          if($uploadedFiles)
          {
              foreach ($uploadedFiles as $uploadedFile)
              {
                  $this->move($uploadedFile);
              }
          }
      }
}