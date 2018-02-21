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
use App\Core\Container\Container;
use App\Core\Http\ResponseFactory;
use App\Core\Routing\RouteFactory;
use App\Core\Interfaces\ControllerResolverInterface;

class ControllerResolver implements ControllerResolverInterface
{
    /** @var RouteFactory */
    protected $routeFactory;

    /** @var ResponseFactory */
    protected $responseFactory;

    /** @var Container */
    protected $container;

    /**
     * ControllerResolver constructor.
     *
     * @param RouteFactory    $routeFactory
     * @param ResponseFactory $responseFactory
     * @param Container       $container
     */
    public function __construct(
        RouteFactory $routeFactory,
        ResponseFactory $responseFactory,
        Container $container
    ) {
        $this->container = $container;
        $this->routeFactory = $routeFactory;
        $this->responseFactory = $responseFactory;
    }

    public function resolve(Request $request)
    {
        if ($route = $this->routeFactory->resolveRoute($request)) {
            return $this->process($route, $request);
        }

        return $this->responseFactory->notFound();
    }

    protected function process(Route $route, Request $request)
    {
        $controller = $route->getController();

        if ($this->container->hasBind($controller)) {
            $controller = $this->container->resolve($controller);
        } else {
            $controller = (new $controller());
        }

        /** @var $controller AbstractController */
        $controller
            ->setRequest($request)
            ->setResponseFactory($this->responseFactory);

        return call_user_func_array([$controller, $route->getMethod()], $route->getMatches());
    }
}