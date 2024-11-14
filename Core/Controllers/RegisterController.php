<?php 

namespace Core\Controllers;

use Core\Basics\Auth\User;
use Core\Basics\Database\CRUD;

class RegisterController extends Controller {
  
  protected readonly CRUD $CRUD;
  public function __construct() {
    parent::__construct();
    $this->CRUD = new CRUD();
  }
  public function index() {
      
      return $this->render('register', $this->data);
    }

    public function register() {
      if (User::findByEmail($_POST['email'])) {
        $_SESSION['message'] = 'danger#Email already exists';
        header('Location: /register');
        exit();
      }

      $newUser = User::CreateAccount($_POST['email'], $_POST['password'], []);
      $_SESSION['user'] = $newUser->email;
      
      header('Location: /');
      exit();
    }
}

?>