<?php
namespace Jan\Component\Http;


use Jan\Component\Http\Bag\ParameterBag;



/**
 * Class UploadedFile
 * @package Jan\Component\Http
*/
class UploadedFile extends ParameterBag
{

    /**
     * @var string
    */
    private $uploadKey;


    /**
     * @var string
    */
    private $destination = '/uploads';


    /**
     * UploadedFile constructor.
     * @param array $files
    */
    public function __construct(array $files)
    {
        parent::__construct($files);
    }


    /**
     * @param string $uploadKey
    */
    public function setUploadKey(string $uploadKey)
    {
          $this->uploadKey = $uploadKey;
    }


    /**
     * @param $destination
     * @return $this
    */
    public function setDestination($destination)
    {
        $this->destination = $destination;

        return $this;
    }



    /**
     * @return array
    */
    public function files()
    {
        return $this->data[$this->uploadKey] ?? $this->data;
    }


    public function getName()
    {
        $this->data['name'];
    }


    /**
     *
    */
    public function move($filename)
    {
         move_uploaded_file($filename, $this->destination);
    }
}