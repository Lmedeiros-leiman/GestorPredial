<?php

use Controllers\IndexController;
use Router\Router;

// carrega o autoloader e algumas constantes importates.
require_once "../autoloader.php";


// declara as rotas que nossa aplicação vai usar.
$router = new Router();

// lida com a rota padrão.
$router->GET("/", [IndexController::class, "index"]);

// lida com as rotas de autenticação e criação de conta.
$router->GET("/login", [AuthController::class, "login"]);
$router->POST("/login", [AuthController::class, "loginRequest"]);
$router->GET("/register", [AuthController::class, "register"]);
$router->POST("/register", [AuthController::class, "HandleRegister"]);
// lida com as rotas protegidas (requerem login.)
$router->GET("user", [AuthController::class, "UserConfig"]);


//

$router->ParseCurrentRequest();
