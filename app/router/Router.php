<?php

namespace App\app\router;


class Router
{
  public function start()
  {
    $uri = $_SERVER["REQUEST_URI"];

    if ($uri != "/" && $uri[-1] == "/") {
      $uri = \substr($uri, 0, -1);
      \header("location: $uri");
    }

    $params = \explode("/", $_GET["p"]);
    if ($params[0] != "") {
      $controller = "App\\controllers\\" . \ucfirst(\array_shift($params)) . "Controller";

      $action = isset($params[0]) ? \array_shift($params) : "index";

      if (\method_exists($controller, $action)) {
        $controller = new $controller();
        isset($params[0]) ? $controller->$action($params) : $controller->$action();
      } else {
           echo "la page n'existe pas";
      }
    } else {
      echo "testtsdsdfsdfstt";
    }
  }
}
