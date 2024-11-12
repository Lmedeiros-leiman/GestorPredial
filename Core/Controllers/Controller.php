<?php 

namespace Core\Controllers;

use CRUD;

class Controller {
    protected $view;
    protected $data = [];
    
    public function __construct() {
        $this->view = new View();

        $this->data = [
            'title' => 'Gestor predial',
        ];
    }
    
    protected function render($template, $data = []) {
        return $this->view->render($template, $data);
    }
}


?>