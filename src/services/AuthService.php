<?php

namespace services;

use models\UserModel;
use Repositories\User;

class AuthService
{

  /**
   * checkuserauthenticated
   */
  public static function checkUserLogOut($pathToRedirect = "/")
  {
    if (!isset($_SESSION["user"])) {
      \header("location: $pathToRedirect");
      return;
    }
  }

  public static function checkUserLogged($pathToRedirect = "/")
  {
    if (isset($_SESSION["user"])) {
      \header("location: $pathToRedirect");
      return;
    }
  }

  public static function isAdmin()
  {
    if (empty($_SESSION["user"]["id"])) {
      return false;
    }
    $userRepository = new User();
    $currentUser = $userRepository->findOne($_SESSION["user"]["id"]) ?? "";
    $userModel = new UserModel();
    $userModel->hydrate($currentUser);

    $userRole = json_decode($userModel->getRole());

    if (\in_array("ROLE_ADMIN", $userRole)) {
      return true;
    } else {
      return false;
    }
  }

  public static function checkAdmin($pathToRedirect = "/")
  {
    $admin = self::isAdmin();
    if (!$admin) {
      \header("location: $pathToRedirect");
      return;
    }
  }

  public static function createCSRFToken()
  {
    $CSRFToken = bin2hex(random_bytes(32));

    $_SESSION["csrf_token"] = $CSRFToken;
  }

  public static function checkCSRFToken($postToken)
  {
    if ($postToken == $_SESSION["csrf_token"]) {
      return true;
    }
    return false;
  }
}
