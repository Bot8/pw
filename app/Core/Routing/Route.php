<?php
/**
 * Created by PhpStorm.
 * User: artarn
 * Date: 20.02.18
 * Time: 23:55
 */

namespace App\Core\Routing;


class Route
{
    protected $pattern;

    protected $controller;

    protected $method;

    /**
     * Route constructor.
     * @param $pattern
     * @param $controller
     * @param $method
     */
    public function __construct(string $pattern, string $controller, string $method)
    {
        $this->pattern = $pattern;
        $this->controller = $controller;
        $this->method = $method;
    }

    /**
     * @param string $uri
     * @return array|null
     */
    public function match(string $uri)
    {
        $matches = [];
        if (!preg_match($this->pattern, $uri, $matches)) {
            return null;
        }

        return $matches;
    }

    /**
     * @return string
     */
    public function getController()
    {
        return $this->controller;
    }

    /**
     * @return string
     */
    public function getMethod()
    {
        return $this->method;
    }


}