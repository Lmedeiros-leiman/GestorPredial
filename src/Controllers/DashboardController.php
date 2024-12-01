<?php

namespace Controllers;

use Controllers\bases\ProtectedController;
use Database\CRUD;
use Views\Bases\View;

class DashboardController extends ProtectedController {
    public function index() {
        View::renderPage("Dashboard");
    }
    public function getPeople() {
        header('Content-Type: application/json; charset=utf-8');
        $db = new CRUD();
        $data = $db->read("pessoas");
        
        echo json_encode($data);
    }

    public function addPerson() {
        header('Content-Type: application/json; charset=utf-8');
        if (!isset($_POST)) {
            http_response_code(404);
            return "Invalid post request.";
        }
        $db = new CRUD();
        $newId = $db->create("pessoas", $_POST);
        return $db->readId("pessoas",$newId);
        
    }

    public function deletePerson() {
        header('Content-Type: application/json; charset=utf-8');
        if (!isset($_POST["id"])) {
            http_response_code(404);
            return "Invalid post request.";
        }
        $db = new CRUD();
        $db->delete("pessoas", $_POST["id"]);
     
        echo (json_encode(($_POST)));
    }

    public function updatePerson() {
        header('Content-Type: application/json; charset=utf-8');
    }
    
}