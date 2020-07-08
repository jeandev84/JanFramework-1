<?php
namespace Jan\Component\Console\Input;


/**
 * Class ArgvInput
 * @package Jan\Component\Console\Input
*/
class ArgvInput implements InputInterface
{

    /** @var array  */
    private $tokens = [];


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
         $this->tokens = $tokens;
    }


    /**
     * @return mixed|null
    */
    public function getFirstArgument()
    {
       return $this->getToken(0);
    }


    /**
     * @return array|mixed
    */
    public function getTokens()
    {
        return $this->tokens;
    }


    /**
     * @param $index
     * @return mixed|null
    */
    public function getToken($index)
    {
        return $this->tokens[$index] ?? null;
    }
}