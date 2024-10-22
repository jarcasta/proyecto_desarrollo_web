<?php

use Slim\Factory\AppFactory;

define('BASE_VIEW_PATH', __DIR__ . '/../src/Views/');

require __DIR__ . '/../vendor/autoload.php';

$container = new DI\Container();
AppFactory::setContainer($container);
$app = AppFactory::create();

require __DIR__ . '/../src/dependencies.php';
require __DIR__ . '/../src/routes.php';

$app->run();
