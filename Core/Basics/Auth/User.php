<?php 
// Wrapper class for user data.

class User {
    public readonly string $id;
    public readonly string $email;
    public readonly string $password;
    public readonly array $permissions;


    public static function findByEmail() { return null;}
}

?>
