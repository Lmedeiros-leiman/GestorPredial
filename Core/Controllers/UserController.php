<?php 

namespace Core\Controllers;

use Core\Basics\BaseClasses\Controller;

class UserController extends Controller {
    public function show($id) {
        // Logic to show user details based on the ID
        return "Showing user with ID: " . htmlspecialchars($id);
    }
}

?>