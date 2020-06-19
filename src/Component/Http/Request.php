<?php
namespace Jan\Component\Http;


use Jan\Component\Http\Bag\ServerBag;
use Jan\Component\Http\Contract\RequestInterface;


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
     * Get Uri object
     *
     * @var Uri
    */
    private $uri;


    /**
     * Get server Bag
     *
     * @var ServerBag
    */
    private $server;


    /**
     * Get query params
     *
     * @var array
    */
    private $queryParams = [];


    /**
     * Files
     *
     * @var array
    */
    private $files = [];


    /**
     * Request constructor.
     * @param array $queryParams
     * @param array $servers
     * @param array $files
    */
    public function __construct($queryParams = [], $servers = [], $files = [])
    {
        $this->queryParams = $queryParams;
        $this->files = $files;
        $this->server = new ServerBag($servers);
        $this->uri = new Uri($this->getUrl());
    }


    /**
     * @return static
    */
    public static function fromGlobals()
    {
        $request = new static($_GET, $_SERVER, $_FILES);

        return $request;
    }



    /**
     * Get base URL
     *
     * @return string
    */
    public function getBaseUrl()
    {
        return $this->getScheme() .'://'. $this->getHost();
    }



    /**
     * Get URL
     *
     * @return string
    */
    public function getUrl()
    {
        $uri = $this->getServer()->get('REQUEST_URI');
        return $this->getBaseUrl() . $uri;
    }


    /**
     * Get uploaded files
    */
    public function getUploadedFiles()
    {
        $uploadedFiles = [];
        foreach ($this->files as $file)
        {
            $uploadedFiles[] = new UploadedFile($file);
        }
        return $uploadedFiles;
    }


    /**
     * @param string $key
     * @return Upload
    */
    public function upload(string $key)
    {
        $upload = new Upload($this);
        $upload->setUploadKey($key);
        return $upload->move();
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
     * @return array
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
     * @param string $type
     * @return bool
    */
    public function isMethod(string $type)
    {
        return $this->getMethod() === strtoupper($type);
    }
}