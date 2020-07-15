<?php
namespace Jan\Component\Console\Input;


/**
 * Class Input
 * @package Jan\Component\Console\Input
*/
abstract class Input implements InputInterface
{

    /** @var array  */
    protected $tokens = [];


    /** @var mixed  */
    protected $arguments;


    /** @var array  */
    protected $options = [];


    /**
      * Input constructor.
      * @param array $tokens
    */
    public function __construct(array $tokens)
    {
          $this->tokens = $tokens;
          $this->validate();
    }


    /**
     * Validate  params
    */
    public function validate()
    {
        $parses = $this->tokens;
        array_shift($parses);

        if($parses)
        {
            $token = $this->getTokenParses($parses);
            $options = $this->getOptionParses($parses);

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
      * @return string|null
    */
    public function getOption(string $input = '')
    {
        return $this->getParseParameter($this->options, $input);
    }


    /**
     * @param $parameters
     * @param string $input
     * @return string|null
     */
    protected function getParseParameter($parameters, $input = '')
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


    /**
     * @param array $parses
     * @return array|false|string[]
    */
    private function getTokenParses(array $parses)
    {
        if(isset($parses[0]))
        {
            return explode('=', $parses[0], 2);
        }

        return [];
    }


    /**
     * @param array $parses
     * @return array|mixed
    */
    private function getOptionParses(array $parses)
    {
        return $parses[1] ?? [];
    }
}