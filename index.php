<?php
use Core\Basics\Router\Router;

function ViewRoute($file) {
    $baseDir = ROOT_DIR . "Core/Views/";
    return $baseDir . $file;
}

// declare some constant values.
define("ROOT_DIR",__DIR__ . DIRECTORY_SEPARATOR);

// calls autoLoader file
require_once str_replace('/', DIRECTORY_SEPARATOR, ROOT_DIR."Core/Basics/Autoloader.php");

// calls the config file
require_once str_replace('/', DIRECTORY_SEPARATOR, ROOT_DIR."Configurables/Configurables.php");

try {
    $router = new Router();
    $router->parseRequest($_SERVER['REQUEST_URI']);
} catch (Exception $e) {
    echo $e->getMessage();
}
?>