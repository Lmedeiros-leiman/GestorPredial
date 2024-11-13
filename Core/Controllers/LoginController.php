<?php 

namespace Core\Controllers;


class LoginController extends Controller {
   
   
   
   public function index() {
      return $this->render('login', $this->data);
   }

}

?>