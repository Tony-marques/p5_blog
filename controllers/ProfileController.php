<?php

namespace App\controllers;

use App\services\AuthService;
use App\app\FormBuilder;
use App\models\UserModel;
use App\services\ImageService;
use App\services\UserService;
use App\services\UtilService;

class ProfileController extends AbstractController
{
  public function edit($id)
  {
    $id = (int)$id;
    $userModel = new UserModel();
    $user = $userModel->findOne($id);

    if (!$user) {
      \header("location: /utilisateurs");
      exit;
    }

    AuthService::checkUserLogOut();
    $isAdmin = AuthService::isAdmin();

    // not current user profile
    if ($user["id"] != $_SESSION["user"]["id"] && !$isAdmin) {
      \header("location: /profil/edition/{$_SESSION["user"]["id"]}");
      exit;
    }

    // Check image
    if (!empty($_FILES["profil_picture"]["name"])) {
      $path = ImageService::verifyImage($_FILES["profil_picture"], "/profil/edition/{$_SESSION['user']['id']}");
    }

    if (isset($_POST["submit"])) {
      if (!UserService::checkFields($_POST)) {
        UserService::createErrorSessionFields($_POST);
        UserService::createTmpProfileSession($_POST);
        \header("location: /profil/edition/$id");
        exit;
      }

      $newUser = $userModel->setAge($_POST["age"])
        ->setFirstname($_POST["firstname"])
        ->setLastname($_POST["lastname"]);

        $_SESSION["user"]["firstname"] = $_POST["firstname"];
        $_SESSION["user"]["lastname"] = $_POST["lastname"];
        $_SESSION["user"]["age"] = $_POST["age"];

      // 1. The user already has an image but does not submit a new one
      if (!empty($user["avatar"]) && empty($_FILES["profil_picture"]["name"])) {
        $userModel->setAvatar($user["avatar"]);

        $_SESSION["user"]["avatar"] = "{$user['avatar']}";
      }

      // 2. The user already has image and adds one
      if (!empty($user["avatar"]) && !empty($_FILES["profil_picture"]["name"])) {
        $userModel->setAvatar($path);

        if (\file_exists("uploads/profile/{$user["avatar"]}")) {
          \unlink("uploads/profile/{$user["avatar"]}");
        }
        $_SESSION["user"]["avatar"] = "$path";
      }

      // 3. The user don't have image and adds one
      if (empty($user["avatar"]) && !empty($_FILES["profil_picture"]["name"])) {
        $userModel->setAvatar($path);
        $_SESSION["user"]["avatar"] = "$path";
      }

      $newUser->update($id);
      \header("location: /profil/edition/{$_SESSION['user']['id']}");
      exit;
    }

    $form = UserService::createForm($_SESSION, $user);

    return $this->render("profile/edit", [
      "form" => $form->create(),
      "user" => $user
    ]);
  }

  public function delete($id)
  {
    // echo "ok";
    // exit;
    AuthService::checkAdmin(pathToRedirect: "/");

    $id = (int)$id;
    $userModel = new UserModel();
    $user = $userModel->findOne($id);

    if (!$user) {
      \header("location: /utilisateurs");
      exit;
    }

    $userModel->delete($id);

    \header("location: /utilisateurs");
    exit; // test
  }
}
