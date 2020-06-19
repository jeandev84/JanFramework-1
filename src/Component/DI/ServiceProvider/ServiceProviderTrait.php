<?php
namespace Jan\Component\DI\ServiceProvider;


use Jan\Component\DI\Contracts\ContainerInterface;


/**
 * Trait ServiceProviderTrait
 * @package Jan\Component\DI\ServiceProvider
*/
trait ServiceProviderTrait
{

    /** @var ContainerInterface */
    public $container;


    /**
     * @param ContainerInterface $container
     */
    public function setContainer(ContainerInterface $container)
    {
        $this->container = $container;
    }


    /**
     * @return ContainerInterface
    */
    public function getContainer()
    {
        return $this->container;
    }
}