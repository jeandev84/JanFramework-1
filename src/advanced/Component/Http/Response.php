<?php
namespace Jan\Component\Http;


use Jan\Component\Http\Contracts\ResponseInterface;


/**
 * Class Response
 * @package Jan\Component\Http
*/
class Response implements ResponseInterface
{

    use StatusCode;


    /**
     * @var string
    */
    private $protocolVersion = 'HTTP/1.0';


    /**
     * @var string
    */
    private $content;



    /**
     * @var int
    */
    private $status;


    /**
     * @var array
    */
    private $headers = [];


    /**
     * Response constructor.
     *
     * @param string|null $content
     * @param int $status
     * @param array $headers
    */
    public function __construct(string $content = null, int $status = 200, array $headers = [])
    {
         $this->setContent($content);
         $this->setStatus($status);
         $this->setHeaders($headers);
    }


    /**
     * Set protocol version
     *
     * @param string $protocolVersion
     * @return Response
     */
    public function setProtocolVersion($protocolVersion)
    {
        $this->protocolVersion = $protocolVersion;

        return $this;
    }


    /**
     * @param string $content
    */
    public function setContent($content)
    {
        $this->content = $content;
    }


    /**
     * @param int $status
    */
    public function setStatus($status)
    {
        $this->status = $status;
    }


    /**
     * @param array $headers
     * @param null $value
    */
    public function setHeaders($headers, $value = null)
    {
        foreach ($this->parseHeaders($headers, $value) as $key => $value)
        {
            $this->headers[$key] = $value;
        }
    }


    /**
     * Set protocol version
     *
     * @param string $protocolVersion
     * @return $this
    */
    public function withProtocolVersion($protocolVersion)
    {
        $this->setProtocolVersion($protocolVersion);
        return $this;
    }


    /**
     * @return string
    */
    public function getProtocolVersion()
    {
        return $this->protocolVersion;
    }


    /**
     * Set body
     *
     * @param string $content
     * @return Response
    */
    public function withBody($content)
    {
        $this->content = $content;

        return $this;
    }


    /**
     * @return string
    */
    public function getBody()
    {
        return $this->content;
    }


    /**
     * @param array $data
     * @return $this
    */
    public function withJson($data)
    {
        $this->withHeaders('Content-Type', 'application/json');
        return $this->withBody(json_encode($data));
    }


    /**
     * Set status code
     *
     * @param int $status
     * @return Response
    */
    public function withStatus($status)
    {
        $this->status = $status;

        return $this;
    }


    /**
     * @return int
    */
    public function getStatus()
    {
        return $this->status;
    }


    /**
     * Set Headers
     *
     * @param $key
     * @param null $value
     * @return Response
    */
    public function withHeaders($key, $value = null)
    {
        $this->setHeaders($key, $value);
        return $this;
    }


    /**
     * @return array
    */
    public function getHeaders()
    {
        return $this->headers;
    }



    /**
     * @return mixed
    */
    public function sendHeaders()
    {
        foreach ($this->headers as $key => $value)
        {
             header($key .': '. $value);
        }
    }


    /**
     * @return mixed
    */
    public function sendBody()
    {
        echo $this->content;
    }


    /**
     * @return mixed
    */
    public function send()
    {
        if(headers_sent())
        {
            # look for may be return $this / $this->sendBody()
            // return $this;
            return $this->sendBody();
        }

        $this->statusMessage();
        $this->sendHeaders();
        $this->sendBody();
    }


    /**
     * @return $this
    */
    public function statusMessage()
    {
        $message = $this->messages[$this->status] ?? '';

        if(! $this->protocolVersion)
        {
            http_response_code($this->status);
        }

        if($message)
        {
            $this->withHeaders($this->protocolVersion .' '. $this->status .' ' . $message);
        }

        return $this;
    }

    /**
     * @param $key
     * @param $value
     * @return array
    */
    protected function parseHeaders($key, $value)
    {
        return \is_array($key) ? $key : [$key => $value];
    }

}