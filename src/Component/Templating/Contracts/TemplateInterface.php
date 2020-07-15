<?php
namespace Jan\Component\Templating\Contracts;


/**
 * Interface TemplateInterface
 * @package Jan\Component\Templating\Contracts
*/
interface TemplateInterface
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
     public function renderHtml($template);
}