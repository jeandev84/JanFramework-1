<?php
namespace Jan\Component\Http;


use Jan\Component\Http\Bag\ParameterBag;
use Jan\Component\Http\Bag\ServerBag;
use Jan\Component\Http\Contracts\RequestInterface;


/**
 * Class Request
 * @package Jan\Component\Http
*/
class Request implements RequestInterface
{

    const IP_CLIENT_INDEXES = [
        'HTTP_CLIENT_IP',
        'HTTP_X_FORWARDED_FOR',
        'HTTP_X_FORWARDED_FOR'
    ];


    /**
     * Base Url
     *
     * @var string
    */
    private $baseUrl;


    /**
     * Get Uri
     *
     * @var Uri
    */
    private $uri;


    /**
     * Get server
     *
     * @var ServerBag
    */
    public $server;


    /**
     * Parsed body
     *
     * @var mixed
    */
    public $parsedBody;


    /**
     * Get query params
     *
     * @var ParameterBag
    */
    public $queryParams;


    /**
     * @var array
    */
    public $attributes;


    /**
     * Files
     *
     * @var array
    */
    public $files = [];


    /**
     * @var array
    */
    public $cookies = [];


    /**
     * @var array
     */
    public $envs = [];



    /**
     * @var //HeaderBag
    */
    public $headers;


    /**
     * @var array
    */
    public $languages = [];


    /**
     * Request constructor.
     * @param array $queryParams
     * @param array $attributes
     * @param array $servers
     * @param array $files
     * @param array $cookies
     * @param array $envs
     * @param array $headers
     * @param string $content
     */
    public function __construct(
        $queryParams = [],
        $attributes = [],
        $servers = [],
        $files = [],
        $cookies = [],
        $envs = [],
        $headers = [],
        $content = ''
    )
    {
        // call initialise here
        $this->initialise($queryParams, $attributes, $servers, $files, $cookies, $envs, $headers, $content);
    }


    /**
     * @param array $queryParams
     * @param array $attributes
     * @param array $servers
     * @param array $files
     * @param array $cookies
     * @param array $envs
     * @param array $headers
     * @param string $content
    */
    public function initialise(
        $queryParams = [],
        $attributes = [],
        $servers = [],
        $files = [],
        $cookies = [],
        $envs = [],
        $headers = [],
        $content = ''
    )
    {
        $this->setQueryParams(new ParameterBag($queryParams));
        $this->setFiles($files);
        $this->setAttributes($attributes);
        $this->setServer(new ServerBag($servers));
        $this->setUri(new Uri($this->getUrl()));
        $this->setCookies($cookies);
        $this->setHeaders($headers);
        $this->setParsedBody($content);
        $this->setEnv($envs);
        $this->baseUrl = $this->baseUrl();
    }


    /**
     * @param array $queryParams
     * @param array $attributes
     * @param array $servers
     * @param array $files
     * @param array $cookies
     * @param array $headers
     * @param string $content
     * @return Request
    */
    public static function create(
        $queryParams = [],
        $attributes = [],
        $servers = [],
        $files = [],
        $cookies = [],
        $headers = [],
        $content = '')
    {
         $request = new static($queryParams, $attributes, $servers, $files, $cookies, $headers, $content);

         // do something
         // if($request->isCli() && ... do something
         return $request;
    }


    /**
     * @return static
    */
    public static function fromGlobals()
    {
        return self::create($_GET, $_POST, $_SERVER, $_FILES, $_COOKIE);
    }



    /**
     * Get base URL
     *
     * @return string
    */
    public function baseUrl()
    {
        return $this->getScheme() . $this->getHost();
    }



    /**
     * @param $envs
    */
    public function setEnv($envs)
    {
        $this->envs = $envs;
    }


    /**
     * @return array
    */
    public function getEnv()
    {
        return $this->envs;
    }


    /**
     * @param $uri
     */
    public function setUri($uri): void
    {
        $this->uri = $uri;
    }


    /**
     * @param $server
    */
    public function setServer($server): void
    {
        $this->server = $server;
    }


    /**
     * @param array $attributes
    */
    public function setAttributes($attributes)
    {
        $this->attributes = $attributes;
    }


    /**
     * @param mixed $parsedBody
     */
    public function setParsedBody($parsedBody): void
    {
        $this->parsedBody = $parsedBody;
    }


    /**
     * @param $queryParams
     */
    public function setQueryParams($queryParams): void
    {
        $this->queryParams = $queryParams;
    }


    /**
     * @param array $files
     */
    public function setFiles(array $files): void
    {
        $this->files = $files;
    }



    /**
     * @param array $headers
    */
    public function setHeaders($headers): void
    {
        $this->headers = $headers;
    }



    /**
     * Get URL
     *
     * @return string
    */
    public function getUrl()
    {
        return $this->baseUrl() . $this->getServer()->get('REQUEST_URI');
    }


    /**
     * Get uploaded files
     *
     * @param string|null $key
     * @return array
    */
    public function getFiles(string $key = null)
    {
        $uploadedFiles = [];
        $files = $this->files[$key] ?? $this->files;
        foreach ($files as $file)
        {
            $uploadedFiles[] = new UploadedFile($file);
        }
        return $uploadedFiles;
    }


    /**
     * @return bool
    */
    public function isSecure()
    {
        $port = $this->getServer()->get('SERVER_PORT');
        return ($this->getServer()->get('HTTPS') == 'on' || $port == 443);
    }


    /**
     * Is Ajax
     *
     * @return bool
    */
    public function isXhr()
    {
        return $this->getServer()->get('HTTP_X_REQUESTED_WITH') === 'XMLHttpRequest';
    }


    /**
     * @return bool
    */
    public function isCli()
    {
        return php_sapi_name() == 'cli' && $this->getServer()->get('argc') > 0;
    }


    /**
     * Get Scheme
     *
     * @return string
    */
    public function getScheme()
    {
        $isSecure = $this->isSecure();
        return $isSecure ? 'https://' : 'http://';
    }


    /**
     * Get Host
     *
     * @return string
    */
    public function getHost()
    {
        return $this->getServer()->get('HTTP_HOST');
    }


    /**
     * @return mixed|string|null
    */
    public function getPath()
    {
        return $this->getUri()->getPath();
    }



    /**
     * @return ParameterBag
    */
    public function getQueryParams()
    {
        return $this->queryParams;
    }


    /**
     * @return array
    */
    public function getQueryString()
    {
        return $this->getServer()->get('QUERY_STRING');
    }


    /**
     * @return Uri|string
    */
    public function getUri()
    {
        return $this->uri;
    }


    /**
     * Get server
    */
    public function getServer()
    {
        return $this->server;
    }


    /**
     * @param null $key
     * @return mixed|null
    */
    public function server($key = null)
    {
        return $this->getServer()->get($key, $_SERVER);
    }


    /**
     * @return mixed
    */
    public function getMethod()
    {
        return $this->getServer()->get('REQUEST_METHOD');
    }


    /**
     * Determine type of request method
     *
     * @param string $type
     * @return bool
    */
    public function method($type)
    {
        return $this->getMethod() === strtoupper($type);
    }



    /**
     * @param array $cookies
    */
    public function setCookies(array $cookies)
    {
        $this->cookies = $cookies;
    }



    /**
     * @param null $key
     * @return mixed
    */
    public function cookies($key = null)
    {
        // return $this->cookies->get($key);
    }


    /**
     * Get client IP
     *
     * @return string
    */
    public function getIpClient()
    {
         $ip = $this->getServer()->get('REMOTE_ADDR');

         foreach (self::IP_CLIENT_INDEXES as $ipClient)
         {
             if($identified = $this->getServer()->get($ipClient))
             {
                 $ip = $identified;
                 break;
             }
         }

         return $ip;
    }
}