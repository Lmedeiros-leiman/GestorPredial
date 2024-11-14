<?php

use Core\Controllers\Controller;

class PeopleController extends Controller
{
   public function index(){
      return $this->render("Components/index", $this->data);
   }

   public function show(){
      return $this->render("Components/show", $this->data);
   }

   public function create(){
      return $this->render("Components/create", $this->data);
   }
   public function update(){
      return $this->render("Components/update", $this->data);
   }
   public function delete(){
      return $this->render("Components/delete", $this->data);
   }
}



?>