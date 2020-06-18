<?php
namespace Jan\Component\Http\Bag;


/**
 * Class ServerBag
 * @package Jan\Component\Http\Bag
*/
class ServerBag extends Bag
{
     /**
      * ServerBag constructor.
      * @param array $data
     */
     public function __construct(array $data)
     {
         parent::__construct($data);
     }


     public function getProtocolVersion()
     {
         return $this->get('SERVER_PROTOCOL');
     }
}