<?php

require __DIR__ . '/../vendor/autoload.php';

\App\Core\Helpers\Debug::init();

\App\Bootstrap::getInstance()->run();