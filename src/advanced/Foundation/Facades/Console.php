<?php
namespace Jan\Foundation\Facades;


use Jan\Component\Console\Command\Command;
use Closure;

/**
 * Class Console
 * @package Jan\Foundation\Facades
*/
class Console
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
    public static function shedule($name, Closure $closure, $argument = '', $options = '')
    {
         $command = new Command();
         $command->setName($name);
         //$command->setArgument($argument);
         //$command->setOptions($options);
         $closure($command);
         self::instance()->add($name, $command);
    }
}