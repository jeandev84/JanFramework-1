<?php
namespace Jan\Foundation;


use Jan\Component\DI\Contracts\ContainerInterface;


/**
 * Class Facade
 * @package Jan\Foundation
*/
abstract class Facade
{

    /** @var  */
    protected static $container;


    /** @var  */
    protected static $resolved;


    public function __construct(ContainerInterface $container)
    {
        self::setContainer($container);
    }


    /**
     * Set container
     * @param ContainerInterface $container
    */
    public static function setContainer(ContainerInterface $container)
    {
        static::$container = $container;
    }


    /**
     * Get instance of Facade
     *
     * dump($accessor, static::$container)
    */
    public static function getFacadeInstance()
    {
        $accessor = static::getFacadeAccessor();

        if($resolved = static::$resolved[$accessor] ?? null)
        {
            return $resolved;
        }

        return static::$resolved[$accessor] = static::$container->get($accessor);
    }


    /**
     * @param $method
     * @param $arguments
     * @return bool
    */
    public static function __callStatic($method, $arguments)
    {
        $instance = static::getFacadeInstance();

        if(! method_exists($instance, $method))
        {
            return false;
        }

        return $instance->{$method}(...$arguments);
    }

    /** Get name of facade to be resolve in container */
    abstract protected function getFacadeAccessor();
}