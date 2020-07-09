<?php
namespace Jan\Foundation\Facades;


use Jan\Component\Console\Command\Command;
use Jan\Component\Console\Input\ArgvInput;
use Jan\Component\Console\Output\ConsoleOutput;
use Jan\Foundation\Console as Shedule;
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
             self::$instance = new Shedule();
         }

         return self::$instance;
    }


    /**
     * @param $name
     * @param Closure $closure
     * @param array $options
    */
    public static function shedule($name, Closure $closure, array $options = [])
    {
         $command = new Command();
         $command->setName($name);
         $closure($command);
         self::instance()->add($name, $command);
    }
}