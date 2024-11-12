<?php 

namespace Core\Controllers;


class HomeController extends Controller {
    public function index() {
        return $this->render('index', $this->data);
    }

    public function notFound() {
        
        return $this->render('404', $this->data);
    }
}

?>