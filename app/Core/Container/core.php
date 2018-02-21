<?php

use App\Core\Container\Container;
use App\Core\Routing\RouteFactory;
use App\Core\Http\ResponseFactory;
use App\Core\Controller\ControllerResolver;

return [
    ResponseFactory::class    => function (Container $container) {
        return new ResponseFactory();
    },
    RouteFactory::class       => function (Container $container) {
        $routes = $container->resolve('configs')->getConfig('routes');

        return (new RouteFactory())->addRoutes($routes);
    },
    ControllerResolver::class => function (Container $container) {
        $routeFactory = $container->resolve(RouteFactory::class);
        $responseFactory = $container->resolve(ResponseFactory::class);

        return new ControllerResolver($routeFactory, $responseFactory, $container);
    }

];
