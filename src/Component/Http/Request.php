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
     * Request constructor.
    */
    public function __construct($queryParams = [], $servers = [])
    {
        $this->queryParams = $queryParams;
        $this->server = new ServerBag($servers);
        $this->uri = new Uri($this->server->get('REQUEST_URI'));
    }


    /**
     * @return static
    */
    public static function fromGlobals()
    {
        $request = new static($_GET, $_SERVER);

        return $request;
    }



    /**
     *
     * scheme(http/https) + host(myblog.ru/localhost:8000) + uri(/post/1/edit?page=1&sort=asc)
     * @return string
    */
    public function getBaseUrl()
    {
        // scheme(http/https) + host(mysite/localhost:8000) + uri(/post/1/edit?page=1&sort=asc)

        $protocol = 'http';
        if($scheme = $this->server->has('SCHEME'))
        {
            // $protocol = $scheme;
        }

        // getQueryString
        return $this->getScheme() .'://'. $this->getHost() . $this->getPath() . $this->getQueryParams();
    }


    /**
     * Get Scheme
     *
    */
    public function getScheme()
    {
        $isSecure = false;
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
}