<?php
namespace Jan\Component\Http\Contracts;


/**
 * Interface ResponseInterface
 * @package Jan\Component\Http\Contracts
*/
interface ResponseInterface
{

     /**
      * Set body
      *
      * @param $content
      * @return mixed
     */
     public function withBody($content);



     /**
      * Set status code
      *
      * @param int $status
      * @return mixed
     */
     public function withStatus($status);



     /**
      * Set headers
      *
      * @param $headers
      * @return mixed
     */
     public function withHeaders($headers);




     /**
      * Get protocol version
      *
      * @return mixed
     */
     public function getProtocolVersion();



     /**
      * Get Headers
      *
      * @return array
     */
     public function getHeaders();



     /**
      * Get status
      *
      * @return int
     */
     public function getStatus();



     /**
      * Get body
      *
      * @return string
     */
     public function getBody();


     /**
      * Send headers to server
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