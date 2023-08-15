<?php

namespace App\controllers;

use App\services\AuthService;
use App\app\FormBuilder;
use App\models\UserModel;
use App\services\ImageService;
use App\services\UtilService;

class ProfileController extends AbstractController
{
  public function edit($id)
  {
    $id = (int)$id;
    $userModel = new UserModel();
    $user = $userModel->findOne($id);
    AuthService::checkUserLogOut();

    $isAdmin = AuthService::isAdmin();

    // current user is not admin and is not his profile
    if ($user["id"] != $_SESSION["user"]["id"]) {
      echo "dednas";
      header("location: /profil/edition/{$_SESSION["user"]["id"]}");
      exit;
    }

    if (isset($_POST["submit"])) {



      // If user have already image, delete this from /uploads/profile
      if (isset($user["avatar"])) {
        \unlink("uploads/profile/{$user["avatar"]}");
      }

      $path = ImageService::verifyImage($_FILES["profil_picture"], "/profil/edition/{$_SESSION['user']['id']}");
      // UtilService::beautifulArray($_FILES["profil_picture"]);
      $user = $userModel->setAge($_POST["age"])
        ->setFirstname($_POST["firstname"])
        ->setLastname($_POST["lastname"])
        ->setAvatar($path);


      $user->update($id);
      $_SESSION["user"]["avatar"] = "$path";
      \header("location: /profil/edition/{$_SESSION['user']['id']}");
      exit;
    }

    $form = new FormBuilder();
    $form->startForm(attributs: [
      "enctype" => "multipart/form-data"
    ])

      ->startDiv([
        "class" => "form-container"
      ])
      ->startDiv([
        "class" => "form-group"
      ])
      ->setLabel("profil_picture", "Photo de profil")
      ->setInput(type: "file", name: "profil_picture")
      ->endDiv()
      ->startDiv([
        "class" => "form-group"
      ])
      ->setLabel("firstname", "Prénom")
      ->setInput(type: "text", name: "firstname", attributs: [
        "value" => isset($user["firstname"]) ? $user["firstname"] : ""
      ])
      ->endDiv()
      ->startDiv([
        "class" => "form-group"
      ])
      ->setLabel("lastname", "Nom")
      ->setInput(type: "text", name: "lastname", attributs: [
        "value" => isset($user["lastname"]) ? $user["lastname"] : ""
      ])
      ->endDiv()
      ->startDiv([
        "class" => "form-group"
      ])
      ->setLabel("age", "Age")
      ->setInput(type: "text", name: "age", attributs: [
        "value" => isset($user["age"]) ? $user["age"] : ""
      ])
      ->endDiv()

      ->endDiv()
      ->setButton("Modifier mon profil", [
        "class" => "button button-primary button-login"
      ])
      ->endForm();

    return $this->render("profile/edit", [
      "form" => $form->create()
    ]);
  }
}
