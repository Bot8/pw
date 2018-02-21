<?php

namespace App\Core\Routing;

use App\Core\Http\Request;

class RouteFactory
{
    protected $routes = [];

    /**
     * @param array $definedRoutes
     *
     * @return $this
     */
    public function addRoutes(array $definedRoutes)
    {
        foreach ($definedRoutes as $route => $params) {
            $this->parseRoute($route, $params);
        }

        return $this;
    }

    /**
     * @param Request $request
     *
     * @return Route|null
     */
    public function resolveRoute(Request $request)
    {
        if (!isset($this->routes[$request->getMethod()])) {
            return null;
        }

        foreach ($this->routes[$request->getMethod()] as $route) {
            /** @var $route Route */
            if ($matches = $route->match($request->getUri())) {
                return $route->withMatches($matches);
            }
        }

        return null;
    }

    protected function parseRoute($route, $params)
    {
        list($requestMethod, $pattern) = explode(' ', $route);

        if (is_array($params['arguments'])) {
            foreach ($params['arguments'] as $key => $regex) {
                $pattern = str_replace("{{$key}}", "(?P<{$key}>{$regex})", $pattern);
            }
        }

        $pattern = "/^\\" . $pattern . "(\?.*)?$/";

        if (!isset($this->routes[$requestMethod])) {
            $this->routes[$requestMethod] = [];
        }

        $this->routes[$requestMethod][] = new Route(
            $pattern,
            $params['controller'],
            $params['method']
        );
    }

}