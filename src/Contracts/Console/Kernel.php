<?php
namespace Jan\Contracts\Console;


use Jan\Component\Console\Contracts\InputInterface;
use Jan\Component\Console\Contracts\OutputInterface;



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
       * @param mixed $status
       * @return mixed
      */
      public function terminate(InputInterface $input, $status);
}