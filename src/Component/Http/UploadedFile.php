<?php
namespace Jan\Component\Http;


use Jan\Component\Http\Bag\Bag;



/**
 * Class UploadedFile
 * @package Jan\Component\Http
*/
class UploadedFile extends Bag
{

    /**
     * @var string
    */
    private $uploadKey;


    /**
     * UploadedFile constructor.
     * @param array $data
    */
    public function __construct(array $data)
    {
        parent::__construct($data);
    }


    /**
     * @param string $uploadKey
    */
    /*
    public function setUploadKey(string $uploadKey)
    {
          $this->uploadKey = $uploadKey;
    }
    */


    /**
     * @return array
    */
    public function files()
    {
        return $this->data;
    }
}