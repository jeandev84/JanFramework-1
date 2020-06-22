<?php
namespace Jan\Component\Http;


/**
 * Class File (FileBag)
 * @package Jan\Component\Http
*/
class File
{

    private $name;

    private $temp;

    private $error;


    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }


    /**
     * @param mixed $name
     * @return File
    */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }


    /**
     * @return mixed
    */
    public function getTemp()
    {
        return $this->temp;
    }


    /**
     * @param mixed $temp
     * @return File
    */
    public function setTemp($temp)
    {
        $this->temp = $temp;
        return $this;
    }


    /**
     * @return mixed
    */
    public function getError()
    {
        return $this->error;
    }


    /**
     * @param mixed $error
     * @return File
    */
    public function setError($error)
    {
        $this->error = $error;
        return $this;
    }

}