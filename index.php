<?php
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

require "./Configurables/Routes.php"

?>