<?php
namespace Jan\Component\Console\Output;


/**
 * Interface OutputInterface
 * @package Jan\Component\Console\Output
 */
interface OutputInterface
{

    /**
     * @param string $message
     * @return OutputInterface
    */
    public function write($message);


    /**
     * @param string $message
     * @return mixed
    */
    public function writeln($message);



    /**
     * @return mixed
    */
    public function getFormater();


    /**
     * Important handle, may be send message or code etc..
     * @return mixed
    */
    public function send();
}