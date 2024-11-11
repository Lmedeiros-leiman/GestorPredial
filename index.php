<?php

use Core\Basics\Router\Router;

spl_autoload_register(function ($class) {
    // Convert namespace separators to directory separators
    
    $class = str_replace('\\', DIRECTORY_SEPARATOR, $class);
    
    // Base directory for your classes
    $baseDir = __DIR__ . DIRECTORY_SEPARATOR;
    
    // Build the full path
    $file = $baseDir . $class . '.php';
    // If the file exists, require it
    if (file_exists($file)) {
        require_once $file;
    }
});

require_once __DIR__ . DIRECTORY_SEPARATOR . 'Configurables' . DIRECTORY_SEPARATOR . 'Configurables.php';

$router = new Router();
$router->parseRequest($_SERVER['REQUEST_URI']);
?>