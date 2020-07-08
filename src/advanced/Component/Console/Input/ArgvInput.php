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


    /** @var mixed  */
    private $arguments;


    /** @var array  */
    private $options = [];


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
         $this->parse();
    }


    /**
     * @return mixed|null
    */
    public function getFirstArgument()
    {
        return $this->getToken(0);
    }



    public function parse()
    {
        $parses = $this->tokens;
        array_shift($parses);

        $token = explode('=', $parses[0], 2);
        switch (count($token))
        {
            case 2:
                # php console make:hello -model=User
                $this->arguments[$token[0]] = $token[1]; // "-model=User"
            break;
            default:
                # php console make:hello HomeController
                $this->arguments = (string) $token[0]; // "HomeController"
            break;
        }

    }


    /**
     * @param null $input
     * @return array
    */
    public function getArgument($input = null)
    {
        if(! $input)
        {
            return $this->arguments;
        }

        return $this->arguments[$input] ?? null;
    }


    /**
     * @return array
    */
    public function getArguments()
    {
        return $this->arguments;
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