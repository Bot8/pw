<?php
/**
 * Created by PhpStorm.
 * User: artarn
 * Date: 20.02.18
 * Time: 21:26
 */

namespace App\Core\Controller;

use App\Core\Http\Request;
use App\Core\Routing\Route;
use App\Core\Http\ResponseFactory;
use App\Core\Interfaces\ControllerResolverInterface;

class ControllerResolver implements ControllerResolverInterface
{
    protected $routes = [];

    /**
     * @param array $definedRoutes
     * @return $this
     */
    public function setRoutes(array $definedRoutes)
    {
        foreach ($definedRoutes as $route => $params) {
            $this->parseRoute($route, $params);
        }

        return $this;
    }

    public function resolve(Request $request)
    {
        if (!isset($this->routes[$request->getMethod()])) {
            return ResponseFactory::notFound();
        }

        foreach ($this->routes[$request->getMethod()] as $route) {
            /** @var $route Route */
            if ($matches = $route->match($request->getUri())) {
                return $this->process($route, $request, $matches);
            }
        }

        return ResponseFactory::notFound();
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

    protected function process(Route $route, Request $request, array $matches)
    {
        $controller = $route->getController();

        $controller = (new $controller())->setRequest($request);

        return call_user_func_array([$controller, $route->getMethod()], $matches);
    }
}