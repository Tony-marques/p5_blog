<?php

namespace App\controllers;

class AbstractController
{


  public function render($path, $data = [], $template = "default")
  {
    // print_r($data);

    \extract($data);

    ob_start();

    require_once ROOT . "/templates/$path.php";

    $content = \ob_get_clean();

    require_once ROOT . "/templates/$template.php";
  }
}
