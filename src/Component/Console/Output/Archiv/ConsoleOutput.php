<?php
namespace Jan\Component\Console\Output;


/**
 * Class ConsoleOutput
 * @package Jan\Component\Console\Output
*/
class ConsoleOutput implements OutputInterface
{

    /**
     * @var array
    */
    protected $messages = [];


    /**
     * Output constructor.
    */
    public function __construct()
    {
    }


    /**
     * @param string $message
     * @return ConsoleOutput
     */
    public function write(string $message)
    {
        $this->messages[] = $message;

        return $this;
    }


    /**
     * @param string $message
     * @return mixed
    */
    public function writeln(string $message)
    {
        $this->write($message ."\n");

        return $this;
    }


    /**
     * @return mixed
    */
    public function getFormater()
    {
          //
    }

    /**
     * @return mixed
    */
    public function send()
    {
        return join("\n", $this->messages);
    }

}