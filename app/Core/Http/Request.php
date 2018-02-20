<?php
/**
 * Created by PhpStorm.
 * User: artarn
 * Date: 20.02.18
 * Time: 20:43
 */

namespace App\Core\Http;


class Request
{
    protected $uri;
    protected $method;
    protected $server;

    public function __construct($server)
    {
        $this->server = $server;

        $this->setupUri();
        $this->setupMethod();
    }

    /**
     * @return string
     */
    public function getUri()
    {
        return $this->uri;
    }

    /**
     * @return string
     */
    public function getMethod()
    {
        return $this->method;
    }

    protected function setupUri()
    {
        $this->uri = $this->findUri();
    }

    protected function findUri()
    {
        if (isset($this->server['REQUEST_URI'])) {
            return $this->server['REQUEST_URI'];
        }

        return null;
    }

    protected function setupMethod()
    {
        if (isset($this->server['REQUEST_METHOD'])) {
            return $this->method = $this->server['REQUEST_METHOD'];
        }

        return null;
    }
}