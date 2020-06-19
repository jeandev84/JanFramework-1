<?php
namespace Jan\Component\Http\Contracts;


/**
 * Interface RequestInterface
 * @package Jan\Component\Http\Contracts
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