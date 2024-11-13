<?php

namespace Core\Basics\Router;

use Core\Controllers\HomeController;
use Exception;

class Router {
    private $routes;
    
    public function __construct() {
        $this->routes = [
            'GET' => [
                '/' => ['HomeController', 'index'],
                '/login' => ['LoginController', 'index'],
                '/register' => ['RegisterController', 'index'],
                '/user/{id}' => ['UserController', 'show'] // Example route with a variable
            ],
            'POST' => [
                '/login' => ['LoginController', 'login'],
                '/register' => ['RegisterController', 'register']
            ],
            'DELETE' => [],
            'PUT' => [],
            'PATCH' => []
        ];
    }

    public function ParseRequest($url) {
        $method = $_SERVER['REQUEST_METHOD'];
        
        $url = $_SERVER["REDIRECT_URL"];
        if (!isset($_SESSION["auth"])) {
            if ($url != "/login" && $url != "/register") {
                header("Location: /login");
        } }

        
        if (isset($this->routes[$method][$url])) {
            $action = $this->routes[$method][$url];
            $controller = "Core\\Controllers\\" . $action[0];
            
            $method = $action[1];
            
            $controllerInstance = new $controller();
            
            $controllerInstance->$method();
            
            
            return;
        } 

        // If no route matched, load a public file or 404 page
        $fileURL = str_replace("/", DIRECTORY_SEPARATOR, "./public".$url);

        if (file_exists($fileURL)) {
            echo file_get_contents($fileURL);
        } else {
            $home = new HomeController();
            echo $home->notFound();
        }
    }
}

?>