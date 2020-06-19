<?php
namespace Jan\Component\Console\Input;



/**
 * Class ArgvInput
 * @package Jan\Component\Console\Input\Type
*/
class ArgvInput extends Input
{


    /** @var array */
    protected $tokens;



    /**
     * Input constructor.
     * @param array $tokens [ Arguments CLI $argv or $_SERVER['argv']
     * @param InputBag $inputBag
     */
    public function __construct(array $tokens = null, InputBag $inputBag = null)
    {
        if(is_null($tokens))
        {
            $tokens = $_SERVER['argv'] ?? [];
        }

        array_shift($tokens);
        $this->tokens = $tokens;

        parent::__construct($inputBag);
    }


    /**
     * Get tokens
     * (tokens) in this case are the parses arguments from cli or somewhere
     *
     * @return array|mixed
    */
    public function getTokens()
    {
        return $this->tokens;
    }


    /**
     * Get first argument
    */
    public function getFirstArgument()
    {
       return $this->getToken(0);
    }

    /**
     * @return mixed
    */
    public function process()
    {
         $token = array_shift($this->tokens);

         $this->parseArgument($token);
    }


    /**
     * @param string $token
    */
    protected function parseArgument(string $token)
    {
         // $this->arguments[] = $token;
    }

    /**
     * @param $token
    */
    protected function parseShortOption($token)
    {
          //
    }


    /**
     * @param $token
    */
    protected function parseLongOption($token)
    {
          //
    }


    /**
     * @param string $token
     * @return string
    */
    protected function escapeToken(string $token)
    {
        return trim($token);
    }

    /**
     * @param $key
     * @return array|mixed
    */
    public function getToken($key)
    {
        if(! isset($this->tokens[$key]))
        {
            return '';
        }

        return $this->escapeToken($this->tokens[$key]);
    }
}