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
    private $protocolVersion;


    /**
     * @var string
    */
    private $body;



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
         $this->withBody($content);
         $this->withStatus($status);
         $this->withHeader($headers);
    }


    /**
     * Set protocol version
     *
     * @param string $protocolVersion
     * @return $this
    */
    public function withProtocolVersion(string $protocolVersion)
    {
        $this->protocolVersion = $protocolVersion;

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
     * @param string $body
     * @return Response
    */
    public function withBody(string $body)
    {
        $this->body = $body;

        return $this;
    }


    /**
     * @return string
    */
    public function getBody()
    {
        return $this->body;
    }


    /**
     * @param $body
     * @return $this
    */
    public function withJson(string $body)
    {
        $this->withHeader('Content-Type', 'application/json');
        return $this->withBody(json_encode($body));
    }


    /**
     * Set status code
     *
     * @param int $status
     * @return Response
    */
    public function withStatus(int $status)
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
     * @param $key
     * @param null $value
     * @return Response
    */
    public function withHeader($key, $value = null)
    {
        foreach ($this->parseHeaders($key, $value) as $key => $value)
        {
            $this->headers[$key] = $value;
        }

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
     * Get message from server
     *
     * @return string
    */
    public function getMessage()
    {
         if(! isset($this->messages[$this->status]))
         {
             http_response_code($this->status);
         }

         $this->withHeader($this->protocolVersion .' '. $this->status .' ' . $this->messages[$this->status]);
    }


    /**
     * @return mixed
    */
    public function sendHeaders()
    {
        foreach ($this->headers as $key => $value)
        {
             header(is_null($value) ? $key : $key .': '. $value);
        }
    }


    /**
     * @return mixed
    */
    public function sendBody()
    {
        echo $this->body;
    }


    /**
     * @return mixed
    */
    public function send()
    {
        if(headers_sent())
        {
            return $this;
        }

        $this->sendMessage();
        $this->sendHeaders();
        $this->sendBody();
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