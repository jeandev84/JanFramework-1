<?php
namespace Jan\Component\Http;


/**
 * Class Upload
 * @package Jan\Component\Http
*/
class Upload
{
    /**
     * @var array
     */
    protected $files = [];


    /**
     * @var string
     */
    protected $destination = '/uploads';


    /**
     * UploadedFile constructor.
     * @param array $files
     */
    public function __construct(array $files = [])
    {
        $this->files = $files;
    }


    /**
     * @param $destination
     */
    public function setDestination($destination)
    {
         $this->destination = $destination;
    }


    /**
     * @param string $path
     * @return string
     */
    public function getFilename(string $path)
    {
        return $this->destination .'/'. $path;
    }


    /**
     * @return array
     */
    public function files()
    {
        return $this->files;
    }


    /**
     * Move to destination
     *
     * @param string $filename
     * @param string|null $destination
    */
    public function move(string $filename, string $destination = null)
    {
        move_uploaded_file($filename, $this->destination);
    }
}