<?php
/**
 * Created by PhpStorm.
 * User: artarn
 * Date: 20.02.18
 * Time: 20:43
 */

namespace App\Core\Http;


class Response
{
    const HTTP_OK_CODE = 200;
    const HTTP_OK_STATUS = 'Ok';
    const HTTP_NOT_FOUND_CODE = 404;
    const HTTP_NOT_FOUND_STATUS = 'Not Found';

    protected $httpVersion = '1.1';

    protected $responseCode;

    protected $responseStatus;

    protected $contentType = 'text/html';

    protected $charset = 'UTF-8';

    protected $headers = [];

    protected $content;

    /**
     * @param string $key
     * @param string $value
     * @return $this
     */
    public function addHeader(string $key, string $value)
    {
        $this->headers[$key] = $value;

        return $this;
    }

    /**
     * @param string $httpVersion
     * @return Response
     */
    public function setHttpVersion(string $httpVersion)
    {
        $this->httpVersion = $httpVersion;

        return $this;
    }

    /**
     * @param int $responseCode
     * @return Response
     */
    public function setResponseCode(int $responseCode)
    {
        $this->responseCode = $responseCode;

        return $this;
    }

    /**
     * @param string $responseStatus
     * @return Response
     */
    public function setResponseStatus(string $responseStatus)
    {
        $this->responseStatus = $responseStatus;

        return $this;
    }

    /**
     * @param string $contentType
     * @return Response
     */
    public function setContentType(string $contentType)
    {
        $this->contentType = $contentType;

        return $this;
    }

    /**
     * @param string $charset
     * @return Response
     */
    public function setCharset(string $charset)
    {
        $this->charset = $charset;

        return $this;
    }

    /**
     * @param string $content
     * @return Response
     */
    public function setContent(string $content)
    {
        $this->content = $content;

        return $this;
    }


    public function render()
    {
        $this->sendHeaders();

        echo $this->content;
    }

    protected function sendHeaders()
    {
        header(sprintf('HTTP/%s %s %s', $this->httpVersion, $this->responseCode, $this->responseStatus), true, $this->responseCode);
        header(sprintf('Content-Type: %s; charset=%s', $this->contentType, $this->charset), true, $this->responseCode);

        foreach ($this->headers as $name => $value) {
            header($name . ': ' . $value, false, $this->responseCode);
        }
    }
}