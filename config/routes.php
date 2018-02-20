<?php

return [
    'GET /{file}' => [
        'controller' => \App\Controller\PageController::class,
        'method' => 'readFile',
        'arguments' => [
            'file' => '\w+\.\w{3,4}'
        ],
    ],
    'GET /{page}' => [
        'controller' => \App\Controller\PageController::class,
        'method' => 'readPage',
        'arguments' => [
            'page' => '\w+'
        ],
    ]
];
