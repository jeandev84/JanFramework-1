<?php
namespace Jan\Component\DI\ServiceProvider;


use Jan\Component\DI\Contracts\ServiceProviderInterface;


/**
 * Class AbstractServiceProvider
 * @package Jan\Component\DI\ServiceProvider
*/
abstract class AbstractServiceProvider implements ServiceProviderInterface
{

    use ServiceProviderTrait;


    /**
     * @var array
    */
    protected $provides = [];


     /**
      * @return array
     */
     public function getProvides()
     {
         return $this->provides;
     }
}