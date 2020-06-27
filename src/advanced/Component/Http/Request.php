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
     * @return array
    */
    public function post($key = null)
    {
        return $this->attributes[$key] ?? $this->attributes;
    }


    /**
     * @return array
     */
    public function get($key = null)
    {
        return $this->queryParams->get($key, $_GET);
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
        return $this->files[$key] ?? $this->files;
    }


    /**
     * @param $input
     * @return mixed
     *
     * pathinfo(filename) =
     * [
        "dirname" => "."
        "basename" => "jeandev84.jpg"
        "extension" => "jpg"
        "filename" => "jeandev84"
     * ]
    */
    public function file($input)
    {
        if(empty($this->files[$input]))
        {
            return false;
        }

        $file = $this->files[$input];
        $files = [];

        foreach ($file as $index => $data)
        {
            $data = (array) $data;
            $i = 0;
            foreach ($data as $value)
            {
                $files[$i][$index] = $value;
                $i++;
            }
        }

        $uploadedFiles = [];

        foreach ($files as $file)
        {
            $uploadedFile = new UploadedFile();
            $uploadedFile->setFilename($file['name']);
            $fileInfo = pathinfo($file['name']);

            $uploadedFile->setNameOnly($fileInfo['basename']);
            $uploadedFile->setExtension($fileInfo['extension'] ?? '');
            $uploadedFile->setMimeType($file['type']);
            $uploadedFile->setTempFile($file['tmp_name']);
            $uploadedFile->setError($file['error']);
            $uploadedFile->setSize($file['size']);
            $uploadedFiles[] = $uploadedFile;
        }

        return $uploadedFiles;
    }


    /**
     * @param array $file
     * @return array
     *
     *
      [
        new UploadedFile(),
        new UploadedFile(),
        new UploadedFile()
      ]
    */
    public function getUploadedFiles(array $file)
    {
        $files = [];
        foreach ($file as $index => $data)
        {
            $data = (array) $data;
            $i = 0;
            foreach ($data as $value)
            {
                $files[$i][$index] = $data[$i];
                $i++;
            }
        }

        $uploadedFiles = [];

        foreach ($files as $file)
        {
             $uploadedFile = new UploadedFile();
             $uploadedFile->setFilename($file['name']);
             $uploadedFile->setMimeType($file['type']);
             $uploadedFile->setTempFile($file['tmp_name']);
             $uploadedFile->setError($file['error']);
             $uploadedFile->setSize($file['size']);
             $uploadedFiles[] = $uploadedFile;
        }

        return $uploadedFiles;
    }


    /**
      * @param UploadedFile $uploadedFile
    */
    public function addUploadedFile(UploadedFile $uploadedFile)
    {
           //
    }


    /**
     * Get Scheme
     *
     * @return string
    */
    public function getScheme()
    {
        return $this->isSecure() ? 'https://' : 'http://';
    }


    /**
     * @return mixed|null
    */
    public function getProtocolVersion()
    {
        return $this->getServer()->get('SERVER_PROTOCOL');
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
     * @return bool
    */
    public function isPost()
    {
        return $this->method('POST');
    }
}