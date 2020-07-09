<?php
namespace App\Console;


use Jan\Foundation\Console\Kernel as ConsoleKernel;


/**
 * Class Kernel
 * @package App\Console
*/
class Kernel extends ConsoleKernel
{

     /**
      * @var string[]
     */
     protected $commands = [
         'App\Commands\HelloCommand'
     ];
}