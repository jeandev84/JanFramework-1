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
     * @return string
     */
    public function getUri();



    /**
     * @return string
    */
    public function getMethod();
}