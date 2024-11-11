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
                '/user/{id}' => ['UserController', 'show'] // Example route with a variable
            ],
            'POST' => [],
            'DELETE' => [],
            'PUT' => [],
            'PATCH' => []
        ];
    }

    public function ParseRequest($url) {
        $method = $_SERVER['REQUEST_METHOD'];

        // Check if the URL matches any defined routes
        foreach ($this->routes[$method] as $route => $action) {
            // Use regex to match the route and extract parameters
            $pattern = preg_replace('/\{(\w+)\}/', '(\w+)', $route); // Convert {id} to (\\w+)
            if (preg_match("#^$pattern$#", $url, $matches)) {
                array_shift($matches); // Remove the full match from the array
                $controller = "Core\\Controllers\\" . $action[0];
                $method = $action[1];

                $controllerInstance = new $controller();
                echo $controllerInstance->$method(...$matches); // Pass parameters to the method
                return;
            }
        }

        // If no route matched, load a public file or 404 page
        $fileURL = str_replace("/", DIRECTORY_SEPARATOR, "/public".$url);
        if (file_exists($fileURL)) {
            echo file_get_contents($fileURL);
        } else {
            $home = new HomeController();
            echo $home->notFound();
        }
    }
}

?>