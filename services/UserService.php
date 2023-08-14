<?php

namespace App\services;

use App\models\UserModel;

class UserService
{

  public static function findOne(int $id)
  {
    $userModel = new UserModel();
    $user = $userModel->findOne($_SESSION["user"]["id"]);

    return $user;
  }
}
