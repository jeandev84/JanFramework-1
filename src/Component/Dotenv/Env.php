<?php
namespace Jan\Component\Dotenv;


use Exception;
use Jan\Component\Dotenv\Exceptions\InvalidPathException;


/**
 * Class Env (Environment)
 * @package Jan\Component\Dotenv
*/
class Env
{

    /** @var string */
    protected $basePath;



    /**
     * Env constructor.
     * @param string $basePath
    */
    public function __construct(string $basePath)
    {
         $this->basePath = rtrim($basePath, '\/');
    }


    /**
     * @param string $filename
     * @return Env
     * @throws InvalidPathException
    */
    public function load(string $filename = '.env')
    {
        foreach ($this->getEnvironements($filename) as $env)
        {
            $env = trim(str_replace("\n", '', $env)); // "\r\n"

            if($this->isAvailableEnvironment($env))
            {
                 putenv($env);
                 list($key, $value) = explode('=', $env);
                 $_ENV[$key] = $value;
            }
        }

        /* return $_ENV; */

        return $this;
    }


    /**
     * Get environment from .env file
     *
     * @param string $filename
     * @return array
     */
    public function getEnvironements(string $filename)
    {
        if(strpos($filename, '.') !== false)
        {
            return file($this->getEnvironmentFilename($filename));
        }

    }



    /**
     * @param $filename
     * @return string|bool
    */
    public function getEnvironmentFilename($filename)
    {
        $filename =  $this->basePath . DIRECTORY_SEPARATOR. $filename;

        if(! file_exists($filename))
        {
            /* throw new InvalidPathException(sprintf('Can not find file %s', $filename)); */
            return false;
        }

        return $filename;
    }


    /**
     * @param $environment
     * @return bool
    */
    public function isAvailableEnvironment($environment)
    {
        return strpos($environment, '=') !== false
            && strpos($environment, '#') === false;
    }
}

/*
try {

    $dotenv = (new \Jan\Component\Dotenv\Env(__DIR__.'/../'))
              //->debug(true)
              ->load();

} catch (Exception $e) {

    die($e->getMessage());
}

echo getenv('APP_NAME');
echo '<br>';
echo $_ENV['DB_NAME'];
$_ENV['new'] = 'test';
dump($_ENV);

putenv('EXAMPLE=VALUE');
echo getenv('EXAMPLE');
*/
