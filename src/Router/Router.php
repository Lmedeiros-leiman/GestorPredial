<?php

namespace Router;

use Closure;
use Controllers\IndexController;

// as rotas são definidas no arquivo index.php dentro da pasta public.
// aqui apenas é declarado a classe roteador.
//
class Router {
    protected $routes = [];


    public function ParseCurrentRequest(): void {
        $method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
        $uri = trim($_SERVER['REQUEST_URI'] ?? '/', '/');

        if (isset($this->routes[$method])) {
            foreach ($this->routes[$method] as $route) {
                if (preg_match($route['pattern'], $uri, $matches)) {
                    // Remove the full match and numeric keys, keeping only named parameters
                    $params = array_filter($matches, function($key) {
                        return !is_numeric($key);
                    }, ARRAY_FILTER_USE_KEY);
                    
                    [$controller, $method] = $route['action'];
                    
                    // Call the controller method with the named parameters
                    call_user_func_array([new $controller, $method], array_values($params));
                    return;
                }
            }
        }

        // Default 404 response
        http_response_code(404);
        echo "404 Not Found";
    }

    //
    // compila a rota para adicionar em nossa lista de rotas.
    private function addRoute(string $method, string $path, array $action): void {
        // separa o slug da rota em formato de padrão.
        $pattern = $path = trim($path, '/');
        $pattern = "#^" . preg_replace('/\{([a-zA-Z_][a-zA-Z0-9_]*)\}/', '(?P<\1>[^/]+)', $path) . "$#";

        // adiciona na lista.
        $this->routes[$method][] = [
            'pattern' => $pattern,
            'action' => $action,
        ];
    }

    //
    // comandos para facilitar adicionar rotas na aplicação.
    public function GET($path, $action) {$this->addRoute("GET", $path, $action);}
    public function POST($path, $action) {$this->addRoute("POST", $path, $action);}
    public function DELETE($path, $action) {$this->addRoute("DELETE", $path, $action);}
    public function PATCH($path, $action) {$this->addRoute("PATCH", $path, $action);}
}
