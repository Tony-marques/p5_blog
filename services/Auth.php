<?php

namespace App\services;

use App\models\UserModel;

class Auth
{

  /**
   * checkuserauthenticated
   */
  public static function checkUserLogOut($pathToRedirect = "/")
  {
    if (!isset($_SESSION["user"])) {
      \header("location: $pathToRedirect");
      exit;
    }
  }

  public static function checkUserLogged($pathToRedirect = "/")
  {
    if (isset($_SESSION["user"])) {
      \header("location: $pathToRedirect");
      exit;
    }
  }

  public static function isAdmin()
  {
    $userModel = new UserModel();
    $currentUser = $userModel->findOne($_SESSION["user"]["id"]);
    $userRole = json_decode($currentUser["role"]);

    if (\in_array("ROLE_ADMIN", $userRole)) {
      return true;
    } else {
      return false;
    }
  }
}
