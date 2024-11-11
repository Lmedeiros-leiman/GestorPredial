<?php 

namespace Core\Controllers;

use Core\Basics\BaseClasses\Controller;

class HomeController extends Controller {
    public function index() {
        $data = [];
        return $this->render('index', $data);
    }

    public function notFound() {
        $data = [];
        return $this->render('404', $data);
    }
}

?>