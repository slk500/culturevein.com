<?php

use Psr\Http\Message\ResponseInterface;


class Response extends Message implements ResponseInterface
{
    private $headers = array();

    private $content;

    private $statusCode;

    private $version;

    private $statusText;

    /**
     * Response constructor.
     * @param array $headers
     * @param $content
     * @param $statusCode
     * @param $version
     * @param $statusText
     */
    public function __construct($content, $statusCode, $headers)
    {
        $this->headers = $headers;
        $this->content = $content;
        $this->statusCode = $statusCode;
    }


    public function getStatusCode() : int
    {
        return $this->statusCode;
    }

    public function withStatus($code, $reasonPhrase = '')
    {

    }

    public function getReasonPhrase()
    {

    }

    public function __toString() : string
    {
        return
            sprintf('HTTP/%s %s %s', $this->version, $this->statusCode, $this->statusText)."\r\n".
            $this->headers."\r\n".
            $this->getContent();
    }

    public function getContent()
    {
        $this->content;
    }


}