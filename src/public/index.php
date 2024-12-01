<?php

use Controllers\AuthController;
use Controllers\DashboardController;
use Controllers\IndexController;
use Database\bases\Database;
use Router\Router;

// carrega o autoloader e algumas constantes importates.
require_once "../autoloader.php";

// verifica se o banco de dados esta funcionando
Database::CheckDatabase();

// inicia a sessão da conexão...
session_start();

// declara as rotas que nossa aplicação vai usar.
$router = new Router();

// lida com a rota padrão.
$router->GET("/", [IndexController::class, "index"]);

$router->GET("/dashboard", [DashboardController::class, "index"]);
$router->GET("/api/pessoas", [DashboardController::class, "getPeople"]);
$router->POST("/api/pessoas", [DashboardController::class, "addPerson"]);
$router->POST("/api/pessoas/delete", [DashboardController::class, "deletePerson"]);
$router->POST("/api/pessoas/modify", [DashboardController::class, "updatePerson"]);
//

$router->ParseCurrentRequest();
