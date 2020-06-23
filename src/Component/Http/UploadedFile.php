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
      * @var string
     */
     // protected $input;


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
      * The allowed image extensions
      *
      * @var array
     */
     private $allowedImageExtensions = ['gif', 'jpg', 'jpeg', 'png', 'webp'];


    /**
     * @return string
     */
    public function getFilename(): ?string
    {
        return $this->filename;
    }

    /**
     * @param string $filename
     * @return UploadedFile
     */
    public function setFilename(?string $filename): UploadedFile
    {
        $this->filename = $filename;
        return $this;
    }

    /**
     * @return string
     */
    public function getNameOnly(): ?string
    {
        return $this->nameOnly;
    }

    /**
     * @param string $nameOnly
     * @return UploadedFile
     */
    public function setNameOnly(?string $nameOnly): UploadedFile
    {
        $this->nameOnly = $nameOnly;
        return $this;
    }

    /**
     * @return string
     */
    public function getExtension(): ?string
    {
        return $this->extension;
    }

    /**
     * @param string $extension
     * @return UploadedFile
     */
    public function setExtension(?string $extension): UploadedFile
    {
        $this->extension = $extension;
        return $this;
    }

    /**
     * @return string
     */
    public function getMimeType(): ?string
    {
        return $this->mimeType;
    }

    /**
     * @param string $mimeType
     * @return UploadedFile
     */
    public function setMimeType(?string $mimeType): UploadedFile
    {
        $this->mimeType = $mimeType;
        return $this;
    }

    /**
     * @return string
     */
    public function getTempFile(): string
    {
        return $this->tempFile;
    }

    /**
     * @param string $tempFile
     * @return UploadedFile
     */
    public function setTempFile(?string $tempFile): UploadedFile
    {
        $this->tempFile = $tempFile;
        return $this;
    }

    /**
     * @return int
     */
    public function getSize(): ?int
    {
        return $this->size;
    }


    /**
     * @param int $size
     * @return UploadedFile
    */
    public function setSize(?int $size): UploadedFile
    {
        $this->size = $size;
        return $this;
    }


    /**
     * @return int
    */
    public function getError(): ?int
    {
        return $this->error;
    }


    /**
     * @param int $error
     * @return UploadedFile
     */
    public function setError(?int $error): UploadedFile
    {
        $this->error = $error;
        return $this;
    }



    /**
     * @return array
    */
    public function getAllowedImageExtensions(): array
    {
        return $this->allowedImageExtensions;
    }

    /**
     * @param array $allowedImageExtensions
     * @return UploadedFile
     */
    public function setAllowedImageExtensions(array $allowedImageExtensions): UploadedFile
    {
        $this->allowedImageExtensions = $allowedImageExtensions;
        return $this;
    }
}