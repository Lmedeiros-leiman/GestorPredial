<?php 
// Wrapper class for user data.
namespace Core\Basics\Auth;

use Core\Basics\Database\CRUD;

class User {
    public readonly string $id;
    public readonly string $email;
    public readonly string $password;
    public readonly array $permissions;

    
    

    public static function create(string $email, string $password, array $permissions) {
        
    }
    
    public static function CreateAccount($email, $password, $permissions) {
        $Crud = new CRUD();
        
        $PasswordId = $Crud->Create('secrets', [ 
            'salt' => '',
            'value' => password_hash($password, PASSWORD_BCRYPT) ]);

        $Crud->create('users', [ 
            'email' => $email, 
            'password' => $PasswordId,
            'confirmed_email' => false ]);
        
        return User::findByEmail($email);
    }
    public static function UpdateUser(User $originalUser, User $newUser){

    }
    public function DeleteUser(User $user){

    }

    public static function findByEmail($email) { 
        $Crud = new CRUD();
        $result = $Crud->read('users', [ 'email' => $email ]);
        if (empty($result)) {
            return false;
        } else {
            return $result[0];
        }
    }
}

?>
