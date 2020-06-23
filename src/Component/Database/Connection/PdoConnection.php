<?php
namespace Jan\Component\Database\Connection;


/**
 * Class PdoConnection
 * @package Jan\Component\Database\Connection
*/
class PdoConnection extends \PDO
{
      /**
       * PdoConnection constructor.
       * @param $dsn
       * @param null $username
       * @param null $passwd
       * @param null $options
      */
      public function __construct($dsn, $username = null, $passwd = null, $options = null)
      {
          parent::__construct($dsn, $username, $passwd, $options);
      }
}