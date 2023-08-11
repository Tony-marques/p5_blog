<?php

namespace App\services;

class Auth
{

  public static function isLogOut($pathToRedirect = "/")
  {
      if (!isset($_SESSION["user"])) {
      \header("location: $pathToRedirect");
    }
  }

  public static function isLogged($pathToRedirect = "/")
  {
    if (isset($_SESSION["user"])) {
      \header("location: $pathToRedirect");
    }
  }
}
