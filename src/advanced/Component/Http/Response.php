<?php
namespace Jan\Component\Http;


use Jan\Component\Http\Contracts\ResponseInterface;


/**
 * Class Response
 * @package Jan\Component\Http
*/
class Response implements ResponseInterface
{

    /* use StatusCode; */

    /**
     * @var string[]
     * phrases (message http response)
    */
    protected $messages = [
        // INFORMATIONAL CODES
        100 => 'Continue',
        101 => 'Switching Protocols',
        102 => 'Processing',
        103 => 'Early Hints',
        // SUCCESS CODES
        200 => 'OK',
        201 => 'Created',
        202 => 'Accepted',
        203 => 'Non-Authoritative Information',
        204 => 'No Content',
        205 => 'Reset Content',
        206 => 'Partial Content',
        207 => 'Multi-Status',
        208 => 'Already Reported',
        226 => 'IM Used',
        // REDIRECTION CODES
        300 => 'Multiple Choices',
        301 => 'Moved Permanently',
        302 => 'Found',
        303 => 'See Other',
        304 => 'Not Modified',
        305 => 'Use Proxy',
        306 => 'Switch Proxy', // Deprecated to 306 => '(Unused)'
        307 => 'Temporary Redirect',
        308 => 'Permanent Redirect',
        // CLIENT ERROR
        400 => 'Bad Request',
        401 => 'Unauthorized',
        402 => 'Payment Required',
        403 => 'Forbidden',
        404 => 'Not Found',
        405 => 'Method Not Allowed',
        406 => 'Not Acceptable',
        407 => 'Proxy Authentication Required',
        408 => 'Request Timeout',
        409 => 'Conflict',
        410 => 'Gone',
        411 => 'Length Required',
        412 => 'Precondition Failed',
        413 => 'Payload Too Large',
        414 => 'URI Too Long',
        415 => 'Unsupported Media Type',
        416 => 'Range Not Satisfiable',
        417 => 'Expectation Failed',
        418 => 'I\'m a teapot',
        421 => 'Misdirected Request',
        422 => 'Unprocessable Entity',
        423 => 'Locked',
        424 => 'Failed Dependency',
        425 => 'Too Early',
        426 => 'Upgrade Required',
        428 => 'Precondition Required',
        429 => 'Too Many Requests',
        431 => 'Request Header Fields Too Large',
        444 => 'Connection Closed Without Response',
        451 => 'Unavailable For Legal Reasons',
        // SERVER ERROR
        499 => 'Client Closed Request',
        500 => 'Internal Server Error',
        501 => 'Not Implemented',
        502 => 'Bad Gateway',
        503 => 'Service Unavailable',
        504 => 'Gateway Timeout',
        505 => 'HTTP Version Not Supported',
        506 => 'Variant Also Negotiates',
        507 => 'Insufficient Storage',
        508 => 'Loop Detected',
        510 => 'Not Extended',
        511 => 'Network Authentication Required',
        599 => 'Network Connect Timeout Error',
    ];


    /**
     * @var string
    */
    private $protocolVersion;


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