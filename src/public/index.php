<?php

use Controllers\IndexController;
use Router\Router;

// carrega o autoloader e algumas constantes importates.
require_once "../autoloader.php";


// declara as rotas que nossa aplicação vai usar.
$router = new Router();

$router->GET("/{test}", [IndexController::class, "index"]);


$router->ParseCurrentRequest();
