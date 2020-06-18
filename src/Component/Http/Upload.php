<?php
namespace Jan\Component\Http;


use Jan\Component\Http\Contract\RequestInterface;


/**
 * Class Upload
 * @package Jan\Component\Http
*/
class Upload
{

      /**
       * @var string
      */
      private $uploadKey;


      /**
       * @var array
      */
      private $uploadedFiles = [];


      /**
       * Upload constructor.
       * @param RequestInterface $request
      */
      public function __construct(RequestInterface $request)
      {
          $this->uploadedFiles = $request->getUploadedFiles();
      }


      /**
       * @param string $uploadKey
      */
      public function setUploadKey(string $uploadKey)
      {
          $this->uploadKey = $uploadKey;
      }


      /**
       * @return Upload
      */
      public function move()
      {
          //TODO implement
          return $this;
      }
}