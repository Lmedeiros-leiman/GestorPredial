<?php

namespace Core\Controllers;
class View {
    private $viewPath;
    
    public function __construct() {
        $this->viewPath = str_replace('/', DIRECTORY_SEPARATOR, ROOT_DIR . 'Core/Views/');
    }
    
    public function render($template, $data = []) {
        // Extract data to make variables available in view
        extract($data);
        
        // Start output buffering
        ob_start();
        
        $templatePath = $this->viewPath . $template . '.php';

        if (file_exists($templatePath)) {
            require $templatePath;
        } else {
            throw new \Exception("View template not found: {$templatePath}");
        }
        
        // Return the buffered content
        return ob_get_clean();
    }
}


?>