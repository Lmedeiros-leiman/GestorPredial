<?php

use Core\Basics\Router\Router;

require_once __DIR__ . DIRECTORY_SEPARATOR . 'Core' . DIRECTORY_SEPARATOR . 'Basics' . DIRECTORY_SEPARATOR . 'Autoloader.php';

require_once __DIR__ . DIRECTORY_SEPARATOR . 'Configurables' . DIRECTORY_SEPARATOR . 'Configurables.php';

$router = new Router();
$router->parseRequest($_SERVER['REQUEST_URI']);
?>