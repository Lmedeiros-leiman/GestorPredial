<?php

namespace Router;

use Closure;
use Controllers\IndexController;
use Controllers\NotFoundController;

// as rotas são definidas no arquivo index.php dentro da pasta public.
// aqui apenas é declarado a classe roteador.
//
class Router {
    protected $routes = [];


    public function ParseCurrentRequest(): void {
        $method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
        
        $uri = $_SERVER['REQUEST_URI'] ?? '/';
        $uri = explode("?", $uri);

        $selectedRoute = $this->routes[$method][$uri[0]] ?? null;
        if (isset($selectedRoute)) {
            call_user_func($selectedRoute);
            return;
        }


        call_user_func([new NotFoundController(), "index"]);
        exit();
    }

    //
    // adiciona na lista.
    private function addRoute(string $method, string $path, array $action): void {
        
        $this->routes[$method][$path] = $action;
    }

    //
    // comandos para facilitar adicionar rotas na aplicação.
    public function GET($path, $action) {$this->addRoute("GET", $path, $action);}
    public function POST($path, $action) {$this->addRoute("POST", $path, $action);}
    public function DELETE($path, $action) {$this->addRoute("DELETE", $path, $action);}
    public function PATCH($path, $action) {$this->addRoute("PATCH", $path, $action);}

    // comandos especiais
    public static function redirect($path) {
        header("Location: ". $path);
    }

}
