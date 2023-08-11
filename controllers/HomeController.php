<?php 

namespace App\controllers;

class HomeController extends AbstractController{

  public function index(){
    // echo "homepage $id";
    // var_dump($_SESSION);
    return $this->render("home/index");
  }
}