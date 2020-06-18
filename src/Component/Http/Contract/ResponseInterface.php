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
     public function withHeader(array $headers);




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
      * Get message from server
      *
      * @return mixed
     */
     public function getMessage();


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