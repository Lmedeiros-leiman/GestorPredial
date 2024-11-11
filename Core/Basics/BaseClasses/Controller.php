<?php 

namespace Core\Basics\BaseClasses;

class Controller {
    protected $view;
    
    public function __construct() {
        $this->view = new \Core\Basics\BaseClasses\View();
    }
    
    protected function render($template, $data = []) {
        return $this->view->render($template, $data);
    }
}


?>