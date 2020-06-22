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
     * Files
     *
     * @var array
    */
    private $files = [];


    /**
     * @var array
    */
    private $headers = [];


    /**
     * Request constructor.
     * @param array $queryParams
     * @param array $servers
     * @param array $files
     * @param array $headers
    */
    public function __construct($queryParams = [], $servers = [], $files = [], $headers = [])
    {
        $this->setQueryParams(new ParameterBag($queryParams));
        $this->setFiles($files);
        $this->setServer(new ServerBag($servers));
        $this->setUri(new Uri($this->getUrl()));
        $this->setHeaders($headers);
        $this->baseUrl = $this->baseUrl();
    }


    /**
     * @param array $queryParams
     * @param array $servers
     * @param array $files
     * @param array $headers
     * @param string $content
     * @return Request
    */
    public static function create($queryParams = [], $servers = [], $files = [], $headers = [], $content = '')
    {
         $request = new static($queryParams, $servers, $files);

         // do something
         return $request;
    }


    /**
     * @return static
    */
    public static function fromGlobals()
    {
        return self::create($_GET, $_SERVER, $_FILES);
    }



    /**
     * Get base URL
     *
     * @return string
    */
    public function baseUrl()
    {
        return $this->getScheme() .'://'. $this->getHost();
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
    public function setHeaders(array $headers): void
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

        return false;
    }


    /**
     * Get Scheme
     *
     * @return string
    */
    public function getScheme()
    {
        $isSecure = $this->isSecure();
        return $isSecure ? 'https' : 'http';
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
    public function method(string $type)
    {
        return $this->getMethod() === strtoupper($type);
    }
}