<?php
namespace Jan\Foundation\Routing;


use Jan\Component\DI\Container;


/**
 * Trait ControllerTrait
 * @package Jan\Foundation\Routing
*/
trait ControllerTrait
{

    /**
     * @var Container
    */
    protected $container;


    /**
     * @param Container $container
    */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }


    /**
     * @return Container
    */
    public function getContainer()
    {
        return $this->container;
    }
}