<?php


define("ROOT_DIR",__DIR__);

// função de autoloader
spl_autoload_register(function ($class) {
    
    str_replace("\\","/",$class);
    $filePath = ROOT_DIR . DIRECTORY_SEPARATOR . str_replace('\\', DIRECTORY_SEPARATOR, $class) . ".php";


    require_once $filePath;
});



// função de erro automatico.
set_exception_handler(null);