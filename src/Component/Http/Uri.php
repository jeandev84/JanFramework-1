<?php
namespace Jan\Component\Http;


/**
 * Class Uri
 * @package Jan\Component\Http
*/
class Uri
{

      /**
       * @var string
      */
      private $url;


      /**
      * Uri constructor.
      * @param string $url
      */
      public function __construct(string $url)
      {
          $this->url = $url;
      }


      /**
       * @return mixed|string|null
      */
      public function getPath()
      {
          return $this->getParse(PHP_URL_PATH);
      }


      /**
       * @return mixed|string|null
      */
      public function getQueryParam()
      {
          return $this->getParse(PHP_URL_QUERY);
      }


      /**
       * @return string
      */
      public function getUrl()
      {
          return $this->url; 
      }
      
      
      /**
       * @param int $paramType
       * @return mixed|string|null
      */
      private function getParse(int $paramType)
      {
          return parse_url($this->url, $paramType);
      }
}