<?php
namespace Jan\Component\Console\Command;


use Jan\Component\Console\Input\InputInterface;
use Jan\Component\Console\Output\OutputInterface;


/**
 * Interface CommandInterface
 * @package Jan\Component\Console\Command
 *
 * Command interface
*/
interface CommandInterface
{
    /**
     * Execute command
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return mixed
    */
    public function execute(InputInterface $input, OutputInterface $output);
}