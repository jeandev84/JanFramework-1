<?php
namespace Jan\Component\Http\Contract;


/**
 * Interface ResponseInterface
 * @package Jan\Component\Http\Contract
*/
interface ResponseInterface
{

     /**
      * Set body
      *
      * @param string $content
      * @return mixed
     */
     public function withBody(string $content);



     /**
      * Set status code
      *
      * @param int $status
      * @return mixed
     */
     public function withStatus(int $status);



     /**
      * Set headers
      *
      * @param array $headers
      * @return mixed
     */
     public function withHeaders(array $headers);



     /**
      * Send headers
      *
      * @return mixed
     */
     public function sendHeaders();



    /**
     * Send body
     *
     * @return mixed
    */
    public function sendBody();



    /**
      * Send all response
      *
      * @return mixed
    */
    public function send();
}