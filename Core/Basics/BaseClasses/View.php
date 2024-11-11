<?php

namespace Core\Basics\BaseClasses;
class View {
    private $viewPath =   __DIR__ . DIRECTORY_SEPARATOR . '..'.DIRECTORY_SEPARATOR.'..' . DIRECTORY_SEPARATOR . 'Views'. DIRECTORY_SEPARATOR;
    
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