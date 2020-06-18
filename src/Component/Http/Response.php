<?php
namespace Jan\Component\Http;


use Jan\Component\Http\Contract\ResponseInterface;

/**
 * Class Response
 * @package Jan\Component\Http
*/
class Response implements ResponseInterface
{

    /**
     * @var string
    */
    private $content;



    /**
     * @var int
    */
    private $status;



    /**
     * @var string
    */
    private $versionProtocol;


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
         $this->withHeaders($headers);
    }



    public function withProtocolVersion(string $protocolVersion)
    {
        $this->versionProtocol = $protocolVersion;
    }


    /**
     * @param string $content
     * @return Response
     */
    public function withBody(string $content)
    {
        $this->content = $content;

        return $this;
    }


    /**
     * @param int $status
     * @return Response
     */
    public function withStatus(int $status)
    {
        $this->status = $status;

        return $this;
    }


    /**
     * @param array $headers
     * @return Response
    */
    public function withHeaders(array $headers)
    {
        $this->headers = $headers;

        return $this;
    }


    /**
     *
    */
    public function sendVersionProtocol()
    {

    }


    /**
     * @return mixed
    */
    public function sendHeaders()
    {
        // TODO: Implement sendHeaders() method.
    }


    /**
     * @return mixed
     */
    public function sendBody()
    {
        // TODO: Implement sendBody() method.
    }

    /**
     * @return mixed
     */
    public function send()
    {
        // TODO: Implement send() method.
    }
}