<?php
namespace Jan\Contracts\Console;


use Jan\Component\Console\Input\InputInterface;
use Jan\Component\Console\Output\OutputInterface;



/**
 * Interface Kernel
 * @package Jan\Contracts\Console
*/
interface Kernel
{
      /**
       * @param InputInterface $input
       * @param OutputInterface $output
       * @return mixed
      */
      public function handle(InputInterface $input, OutputInterface $output);


      /**
       * @param InputInterface $input
       * @param $status
       * @return mixed
      */
      public function terminate(InputInterface $input, $status);
}