<?php

namespace App\controllers;

use App\services\AuthService;

class AbstractController
{


  public function render($path, $data = [], $template = "default")
  {
    // print_r($data);

    \extract($data);

    ob_start();

    require_once ROOT . "/templates/$path.php";

    $content = \ob_get_clean();

    // Render true or false for navbar
    $isAdmin = AuthService::isAdmin();
    require_once ROOT . "/templates/$template.php";
  }
}
