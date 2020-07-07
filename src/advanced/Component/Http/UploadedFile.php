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
      * The uploaded file name
      *
      * @var string
     */
     protected $filename;


     /**
      * The uploaded file name without its extension
      *
      * @var string
     */
     protected $nameOnly;


     /**
      * The uploaded file extension
      *
      * @var string
     */
     private $extension;


     /**
      * The uploaded file mime type
      *
      * @var string
     */
     private $mimeType;



     /**
      * The uploaded temp file path
      *
      *
      * @var string
     */
     private $tempFile;


     /**
      * The uploaded file size in bytes
      *
      *
      * @var int
     */
     private $size;


     /**
      * The uploaded file error
      *
      *
      * @var int
     */
     private $error;



     /**
      * The allowed file extensions
      *
      * @var array
     */
     private $allowedExtensions = ['gif', 'jpg', 'jpeg', 'png', 'webp'];



     private $errors = [];


     /**
      * @param $name
      * @param $message
     */
     public function addError($name, $message)
     {
           $this->errors[$name] = $message;
     }


     /**
      * @return string
     */
     public function getFilename()
     {
        return $this->filename;
    }



    /**
     * @param string $filename
     * @return UploadedFile
     */
    public function setFilename($filename): UploadedFile
    {
        $this->filename = $filename;
        return $this;
    }

    /**
     * @return string
     */
    public function getNameOnly()
    {
        return $this->nameOnly;
    }

    /**
     * @param string $nameOnly
     * @return UploadedFile
     */
    public function setNameOnly($nameOnly)
    {
        $this->nameOnly = $nameOnly;
        return $this;
    }

    /**
     * @return string
     */
    public function getExtension()
    {
        return $this->extension;
    }

    /**
     * @param string $extension
     * @return UploadedFile
     */
    public function setExtension($extension): UploadedFile
    {
        $this->extension = $extension;
        return $this;
    }

    /**
     * @return string
     */
    public function getMimeType()
    {
        return $this->mimeType;
    }

    /**
     * @param string $mimeType
     * @return UploadedFile
     */
    public function setMimeType($mimeType): UploadedFile
    {
        $this->mimeType = $mimeType;
        return $this;
    }

    /**
     * @return string
     */
    public function getTempFile()
    {
        return $this->tempFile;
    }

    /**
     * @param string $tempFile
     * @return UploadedFile
     */
    public function setTempFile($tempFile): UploadedFile
    {
        $this->tempFile = $tempFile;
        return $this;
    }

    /**
     * @return int
     */
    public function getSize()
    {
        return $this->size;
    }


    /**
     * @param int $size
     * @return UploadedFile
    */
    public function setSize($size): UploadedFile
    {
        $this->size = $size;
        return $this;
    }


    /**
     * @return int
    */
    public function getError()
    {
        return $this->error;
    }


    /**
     * @param int $error
     * @return UploadedFile
     */
    public function setError($error): UploadedFile
    {
        $this->error = $error;
        return $this;
    }



    /**
     * @return array
    */
    public function getAllowedExtensions()
    {
        return $this->allowedExtensions;
    }

    /**
     * @param array $allowedExtensions
     * @return UploadedFile
    */
    public function setAllowedExtensions($allowedExtensions): UploadedFile
    {
        $this->allowedExtensions = array_merge($this->allowedExtensions, $allowedExtensions);
        return $this;
    }


    /**
     * Upload file
     *
     * @param $target [ __DIR__.'/uploads']
     * @param $filename
     * @return bool|string
    */
    public function move($target, $filename = null)
    {
        if($this->error != UPLOAD_ERR_OK) {

            return false;
        }

        if(! \in_array($this->extension, $this->allowedExtensions))
        {
            return false;
        }

        $filename = $filename ?? sha1(mt_rand()) . '_' . sha1(mt_rand());
        $filename .= '.'. $this->extension;

        if(! is_dir($target))
        {
            mkdir($target, 0777, true);
        }

        $uploadedFilePath = rtrim($target, '/') . '/'. $filename;

        if(move_uploaded_file($this->tempFile, $uploadedFilePath))
        {
            return $filename;
        }

        return false;
    }
}