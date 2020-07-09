<?php
namespace Jan\Foundation\Facades;


use Jan\Component\Console\Command\Command;
use Closure;

/**
 * Class Schedule
 * @package Jan\Foundation\Facades
*/
class Schedule
{

    /** @var Console */
    private static $instance;


    /**
     * @return Console
    */
    public static function instance()
    {
         if(! self::$instance)
         {
             self::$instance = new Console();
         }

         return self::$instance;
    }


    /**
     * @param $name
     * @param Closure $closure
    */
    public static function command($name, Closure $closure)
    {
         $command = new Command();
         $command->setName($name);
         $closure($command);
         self::instance()->addCommand($command);
    }
}