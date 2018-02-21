<?php

use App\Repository as R;
use App\Controller as C;
use App\Core\Storage as S;
use App\Core\Container\Container;
use App\DAO\Database\PageFactory;

return [
    R\PageRepository::class => function (Container $container) {
        return new R\PageRepository(
            $container->resolve(S\Database::class),
            $container->resolve(S\Filesystem::class),
            new PageFactory()
        );
    },
    C\PageController::class => function (Container $container) {
        return new C\PageController($container->resolve(R\PageRepository::class));
    },
    S\Filesystem::class => function (Container $container) {
        return new S\Filesystem($container->resolve('configs')->getConfig('app')['storage_dir']);
    }
];