<?php
namespace Jan\Component\Console\Output;


/**
 * Class ConsoleOutput
 * @package Jan\Component\Console\Output
*/
class ConsoleOutput implements OutputInterface
{


    /**
     * @param string $message
     * @return OutputInterface
    */
    public function write(string $message)
    {
        // TODO: Implement write() method.
    }


    /**
     * @param string $message
     * @return mixed
    */
    public function writeln(string $message)
    {
        // TODO: Implement writeln() method.
    }


    /**
     * @return mixed
    */
    public function getFormater()
    {
        // TODO: Implement getFormater() method.
    }


    /**
     * @return mixed
    */
    public function send()
    {
        // TODO: Implement send() method.
    }
}