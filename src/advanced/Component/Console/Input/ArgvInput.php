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

        if($parses)
        {
            $token = isset($parses[0]) ? explode('=', $parses[0], 2) : [];
            $options = $parses[1] ?? [];

            $tokenCount = count($token);
            $optionCount = count($options);

            if($tokenCount === 2 && ! $optionCount) {

                # php console make:hello -model=User
                $this->arguments[$token[0]] = $token[1]; // "-model=User"

            } elseif ($tokenCount === 2 && $optionCount === 2) {

                $this->arguments[$token[0]] = $token[1];
                $this->options[$options[0]] = $options[1];

            } else {

                # php console make:hello HomeController
                $this->arguments = (string) $token[0]; // "HomeController"
                $this->options   = $optionCount ? (string) $options[0] : '';
            }
        }
    }


    /**
     * @param string $input
     * @return string
     */
    public function getArgument(string $input = '')
    {
        return $this->getParameter($this->arguments, $input);
    }


    public function getOption(string $input = '')
    {
        return $this->getParameter($this->options, $input);
    }

    /**
     * @param $parameters
     * @param string $input
     * @return string|null
    */
    private function getParameter($parameters, $input = '')
    {
        if(! $input)
        {
            if(is_string($parameters))
            {
                return $parameters;
            }

            return '';
        }

        return $parameters[$input] ?? null;
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