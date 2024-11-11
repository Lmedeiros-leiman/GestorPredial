<?php

use Core\Basics\Router\Router;

require_once str_replace("/", DIRECTORY_SEPARATOR ,__DIR__ . "/Core/Basics/Autoloader.php");

require_once str_replace("/",DIRECTORY_SEPARATOR, __DIR__ ."/Configurables/Configurables.php");

$router = new Router();
$router->parseRequest($_SERVER['REQUEST_URI']);
?>