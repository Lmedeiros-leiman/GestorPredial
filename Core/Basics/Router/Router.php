<?php

namespace Core\Basics\Router;

use Core\Controllers\HomeController;
use Exception;

class Router {
    private $routes;
    
    public function __construct() {
        $this->routes = [
            'GET' => [
                '/' => ['HomeController', 'index']
            ],
            'POST' => [],
            'DELETE' => [],
            'PUT' => [],
            'PATCH' => []
        ];
    }
    public function ParseRequest($url) {
        if (isset($this->routes[$_SERVER['REQUEST_METHOD']][$url])) {
            $route = $this->routes[$_SERVER['REQUEST_METHOD']][$url];
            $controller = "Core\\Controllers\\" . $route[0];
            $method = $route[1];
            
            $controllerInstance = new $controller();
            echo $controllerInstance->$method();
        }
    }
}

?>