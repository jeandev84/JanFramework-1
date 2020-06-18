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
      private $baseUrl;


      /**
      * Uri constructor.
      * @param string $baseUrl
      */
      public function __construct(string $baseUrl)
      {
          $this->baseUrl = $baseUrl;
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
       * @param int $paramType
       * @return mixed|string|null
      */
      private function getParse(int $paramType)
      {
          return parse_url($this->baseUrl, $paramType);
      }
}