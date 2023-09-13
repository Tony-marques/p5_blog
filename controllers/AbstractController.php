<?php

namespace App\controllers;

use App\services\AuthService;

class AbstractController
{
  public function render($path, $title, $data = [], $template = "default")
  {
    \extract($data);

    ob_start();

    require_once ROOT . "/templates/$path.php";

    $content = \ob_get_clean();

    // Render true or false for navbar
    $isAdmin = AuthService::isAdmin();
    require_once ROOT . "/templates/$template.php";


    unset($_SESSION["error"]);
    unset($_SESSION["temporary_user"]);
    unset($_SESSION["success"]);
    unset($_SESSION["image"]);
    unset($_SESSION["comment"]);
    unset($_SESSION["profile"]);
    unset($_SESSION["tmp_article"]);
    unset($_SESSION["contact"]);
  }
}
