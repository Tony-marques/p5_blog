<?php 

namespace App\controllers;

use App\services\UtilService;

class HomeController extends AbstractController{

  public function index(){
    UtilService::beautifulArray($_SESSION);
    
    return $this->render("home/index");
  }
}