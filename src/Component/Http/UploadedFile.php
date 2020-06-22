<?php
namespace Jan\Component\Http;


use Jan\Component\Http\Bag\ParameterBag;



/**
 * Class UploadedFile
 * @package Jan\Component\Http
*/
class UploadedFile
{

     /**
      * @var array
     */
     protected $file;


     /**
      * UploadedFile constructor.
      * @param array $file
     */
     public function __construct(array $file)
     {
          $this->file = $file;
     }


     /**
      * @return mixed
     */
     public function getName()
     {
         return $this->file['name'];
     }


     /**
      * @return mixed
     */
     public function getTemp()
     {
         return $this->file['temp'];
     }


     /**
      * @return mixed
     */
     public function getError()
     {
         return $this->file['error'];
     }


     public function getMime()
     {
         return $this->file['mime'];
     }
}