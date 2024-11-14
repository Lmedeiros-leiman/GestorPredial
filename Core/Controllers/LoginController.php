<?php 

namespace Core\Controllers;

use Core\Basics\Auth\User;

class LoginController extends Controller {
   
   
   public function index() {
      
      return $this->render('login', $this->data);
   }

   public function login() {
      echo "yo waddup";
      if (!isset($_POST['email']) || !isset($_POST['password'])) {
         header('Location: /login');
         exit();
      }

      $email = $_POST['email'];
      $password = $_POST['password'];
      $user = User::findByEmail($email);

      var_dump($user);
      var_dump(password_verify($password, $user->password));

      return;
      if ( isset($user) && password_verify($password, $user->password)) {
         $_SESSION['user'] = $user->email;
         
         unset($_SESSION['message']);
         header('Location: /dashboard');
         exit();
      } else {
         $_SESSION['message'] = 'danger#Invalid email or password';
         header('Location: /login');
      }

   }

   public function logout() {

   }
   

}

?>