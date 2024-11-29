<?php

namespace Views\Bases;

define("VIEW_DIR",__DIR__."/../");

class View {
    public static function renderPage($model) {
        
        
        require VIEW_DIR . "pages/" . $model . ".php";
    }
}
