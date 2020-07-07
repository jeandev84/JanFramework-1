<?php
namespace Jan\Component\Templating\Contracts;


/**
 * Interface ViewInterface
 * @package Jan\Component\Templating\Contracts
*/
interface ViewInterface
{
     /**
      * @param $name
      * @param $value
      * @return mixed
     */
     public function setVariable($name, $value);


     /**
      * @param $template
      * @return mixed
     */
     public function getHtml($template);
}