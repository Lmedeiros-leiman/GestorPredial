<?php 

namespace Controllers;

use Views\Bases\View;

class IndexController {

    public static function index() {
        View::renderPage("Home");
    }
    
}