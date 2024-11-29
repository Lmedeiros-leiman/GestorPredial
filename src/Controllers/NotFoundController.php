<?php

namespace Controllers;

class NotFoundController {
    
    public function __construct() {
        http_response_code(404);
    }

    public function index() {
        
        echo "Page not found.";
        return;
    }

}