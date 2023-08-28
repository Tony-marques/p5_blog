<?php

namespace App\controllers;

use App\services\UtilService;

class HomeController extends AbstractController
{
  public function index()
  {
    

    return $this->render("home/index");
  }
}
