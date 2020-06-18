<?php
namespace Jan\Component\Http\Contract;


/**
 * Interface RequestInterface
 * @package Jan\Component\Http\Contract
*/
interface RequestInterface
{

    /**
     * @return string
    */
    public function getBaseUrl();


    /**
     * @return mixed
    */
    public function getUri();



    /**
     * @return mixed
    */
    public function getMethod();


    /**
     * @return mixed
    */
    public function getUploadedFiles();
}