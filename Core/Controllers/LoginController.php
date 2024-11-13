<?php 

namespace Core\Controllers;


class LoginController extends Controller {
   
   public function __construct() {
      $this->data['title'] = 'Login';
   }
   
   public function index() {
      
        return $this->render('index', $this->data);
    }
    
}

?>