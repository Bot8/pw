<?php

use App\Core\Storage\Database;
use App\Core\Container\Container;
use App\Core\Routing\RouteFactory;
use App\Core\Http\ResponseFactory;
use App\Core\Controller\ControllerResolver;

return [
    ResponseFactory::class    => function (Container $container) {
        return new ResponseFactory(
            $container->resolve('configs')->getConfig('app')['template_dir'],
            $container->resolve('page_not_found_view')
        );
    },
    RouteFactory::class       => function (Container $container) {
        $routes = $container->resolve('configs')->getConfig('routes');

        return (new RouteFactory())->addRoutes($routes);
    },
    ControllerResolver::class => function (Container $container) {
        $routeFactory = $container->resolve(RouteFactory::class);
        $responseFactory = $container->resolve(ResponseFactory::class);

        return new ControllerResolver($routeFactory, $responseFactory, $container);
    },
    Database::class           => function (Container $container) {
        $config = $container->resolve('configs')->getConfig('database');

        return new Database($config['host'], $config['database'], $config['user'], $config['password'], $config['charset']);
    },
    'page_not_found_view'     => new \App\Core\View('404')

];
