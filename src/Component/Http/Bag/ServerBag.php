<?php
namespace Jan\Component\Http\Bag;


/**
 * Class ServerBag
 * @package Jan\Component\Http\Bag
*/
class ServerBag extends ParameterBag
{
     /**
      * ServerBag constructor.
      * @param array $data
     */
     public function __construct(array $data)
     {
         parent::__construct($data);
     }


     /**
      * @return mixed|null
     */
     public function getProtocolVersion()
     {
         return $this->get('SERVER_PROTOCOL');
     }
}