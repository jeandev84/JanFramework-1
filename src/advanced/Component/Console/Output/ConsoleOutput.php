<?php
namespace Jan\Component\Console\Output;


/**
 * Class ConsoleOutput
 * @package Jan\Component\Console\Output
*/
class ConsoleOutput implements OutputInterface
{


    /** @var array  */
    private $messages = [];


    /**
     * @param string $message
     * @return OutputInterface
    */
    public function write(string $message)
    {
         $this->messages[] = $message;

         return $this;
    }


    /**
     * @param string $message
     * @return OutputInterface
    */
    public function writeln(string $message)
    {
        return $this->write("$message\n");
    }


    /**
     * @return string
    */
    public function getFormater()
    {
        return '';
    }


    /**
     * @return string
    */
    public function send()
    {
        return join("\n", $this->messages) . "\n";
    }
}