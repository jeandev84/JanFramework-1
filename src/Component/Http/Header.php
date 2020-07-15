<?php
namespace Jan\Component\Http;


/**
 * Class Header
 * @package Jan\Component\Http
*/
class Header
{

     /**
      * @param $header
     */
     public function set($header)
     {
         header($header);
     }


     /**
      * @return array
     */
     public function list()
     {
          return headers_list();
     }


     /**
      * @param $name
      * @return void
     */
     public function remove($name)
     {
         header_remove($name);
     }


     /**
      * @return bool
     */
     public function sent()
     {
         return headers_sent();
     }
}