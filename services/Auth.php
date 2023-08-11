<?php

namespace App\services;

class Auth
{

  public static function isLogOut($pathToRedirect = "/")
  {
      if (!isset($_SESSION["user"])) {
      \header("location: $pathToRedirect");
      exit;
    }
  }

  public static function isLogged($pathToRedirect = "/")
  {
    if (isset($_SESSION["user"])) {
      \header("location: $pathToRedirect");
      exit;

    }
  }
}
