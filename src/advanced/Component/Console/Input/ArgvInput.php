<?php
namespace Jan\Component\Console\Input;


/**
 * Class ArgvInput
 * @package Jan\Component\Console\Input
*/
class ArgvInput extends Input
{

    /**
     * ArgvInput constructor.
     * @param array $tokens
    */
    public function __construct(array $tokens = null)
    {
         if(! $tokens)
         {
             $tokens = $_SERVER['argv'] ?? [];
         }

         array_shift($tokens);

         parent::__construct($tokens);
    }


    /**
     * @return mixed|null
    */
    public function getFirstArgument()
    {
        return $this->getToken(0);
    }


    /**
     * @param string $input
     * @return string
    */
    public function getArgument(string $input = '')
    {
        return $this->getParseParameter($this->arguments, $input);
    }
}