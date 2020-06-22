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
     * Request constructor.
     * @param array $queryParams
     * @param array $servers
     * @param array $files
    */
    public function __construct($queryParams = [], $servers = [], $files = [])
    {
        $this->queryParams = new ParameterBag($queryParams);
        $this->files = $files;
        $this->server = new ServerBag($servers);
        $this->uri = new Uri($this->getUrl());
    }



    /**
     * @param array $queryParams
     * @param array $servers
     * @param array $files
    */
    public static function create($queryParams = [], $servers = [], $files = [])
    {
         //
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
        return $this->getBaseUrl() . $this->getServer()->get('REQUEST_URI');
    }


    /**
     * Get uploaded files
     *
     * @param string|null $uploadKey
     * @return array
     */
    public function getUploadedFiles(string $uploadKey = null)
    {
        $uploadedFiles = [];
        foreach ($this->files as $file) // as $key => $files
        {
            $uploadedFile = new UploadedFile($file);
            $uploadedFile->setUploadKey($uploadKey);
            $uploadedFiles[] = $uploadedFile;
        }
        return $uploadedFiles;
    }


    /**
     * @param string|null $key
     * @return
    */
    public function upload(string $key = null)
    {
        foreach ($this->getUploadedFiles($key) as $uploadedFile)
        {
            $uploadedFile->move();
        }
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