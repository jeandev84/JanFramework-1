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


    /** @var bool  */
    protected $debug = false;


    /**
     * Env constructor.
     * @param string $basePath
    */
    public function __construct(string $basePath)
    {
        $this->basePath = rtrim($basePath, '\/');
    }


    /**
     * Set status debug for mode development (DEBUG)
     *
     * @param bool $status
     * @return Env
    */
    public function debug($status = false)
    {
        $this->debug = $status;
        return $this;
    }


    /**
     * @return array
     * @throws Exception
    */
    public function load()
    {
        foreach ($this->getEnvironements() as $environment)
        {
            /* $environment = trim(str_replace("\r\n", '', $environment)); */
            $environment = trim(str_replace("\n", '', $environment));

            if($this->isAvailableEnvironment($environment))
            {
                 putenv($environment);
                 list($key, $value) = explode('=', $environment);
                 if($this->debug === true) {
                     $_ENV[$key] = $value;
                 }
            }
        }

        return $_ENV ?? [];
    }


    /**
      * Get environment from .env file
      *
      * @return array|false
      * @throws Exception
    */
    public function getEnvironements()
    {
        $filename = $this->basePath . DIRECTORY_SEPARATOR.'.env';

        if(! file_exists($filename))
        {
            throw new InvalidPathException(sprintf('Can not find file .env'));
        }
        return file($filename);
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
