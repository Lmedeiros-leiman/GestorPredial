<?php 

namespace Core\Controllers;


class RegisterController extends Controller {
    public function index() {
      return $this->render('register', $this->data);
    }

    
}

?>