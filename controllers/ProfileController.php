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
      header("location: /profil/edition/{$_SESSION["user"]["id"]}");
      exit;
    }

    // Check image
    if (!empty($_FILES["profil_picture"]["name"])) {
      $path = ImageService::verifyImage($_FILES["profil_picture"], "/profil/edition/{$_SESSION['user']['id']}");
    }

    if (isset($_POST["submit"])) {
      if (
        \strlen($_POST["firstname"]) < 3
        || \strlen($_POST["lastname"]) < 3
        || (!\filter_var($_POST["age"], \FILTER_VALIDATE_INT) || $_POST["age"] > 100 || $_POST["age"] <= 0)
      ) {

        $_SESSION["error"] = [
          "profile" => [
            "firstname" => \strlen($_POST["firstname"]) < 3 ? "Votre prénom doit faire au minimum 3 caractères" : "",
            "lastname" =>  \strlen($_POST["lastname"]) < 3 ? "Votre nom doit faire au minimum 3 caractères" : "",

            "age" => (!\filter_var($_POST["age"], \FILTER_VALIDATE_INT)) ? "Ce n'est pas un nombre" : (($_POST["age"] > 100 || $_POST["age"] <= (int)0) ? "Votre age doît être comprit entre 1 et 100 ans" : ""),
          ]
        ];

        $_SESSION["tmp_profile"] = [
          "firstname" => \htmlspecialchars($_POST["firstname"]),
          "lastname" => \htmlspecialchars($_POST["lastname"]),
          "age" => \htmlspecialchars($_POST["age"]),
        ];

        \header("location: /profil/edition/$id");
        exit;
      }
      $newUser = $userModel->setAge($_POST["age"])
        ->setFirstname($_POST["firstname"])
        ->setLastname($_POST["lastname"]);

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
        "value" => !empty($_SESSION["error"]["profile"]["firstname"]) ? ($_SESSION["tmp_profile"]["firstname"]) : $user["firstname"]
      ])
      ->startDiv(attributs: [
        "class" => !empty($_SESSION["error"]["profile"]["firstname"]) ? "error mt-10" : ""
      ], content: !empty($_SESSION["error"]["profile"]["firstname"]) ? $_SESSION["error"]["profile"]["firstname"] : "")
      ->endDiv()
      ->endDiv()
      ->startDiv([
        "class" => "form-group"
      ])
      ->setLabel("lastname", "Nom")
      ->setInput(type: "text", name: "lastname", attributs: [
        "value" => !empty($_SESSION["error"]["profile"]["lastname"]) ? ($_SESSION["tmp_profile"]["lastname"]) : $user["lastname"]
      ])
      ->startDiv(attributs: [
        "class" => !empty($_SESSION["error"]["profile"]["lastname"]) ? "error mt-10" : ""
      ], content: !empty($_SESSION["error"]["profile"]["lastname"]) ? $_SESSION["error"]["profile"]["lastname"] : "")
      ->endDiv()
      ->endDiv()
      ->startDiv([
        "class" => "form-group"
      ])
      ->setLabel("age", "Age")
      ->setInput(type: "text", name: "age", attributs: [
        "value" => !empty($_SESSION["error"]["profile"]["age"]) ? ($_SESSION["tmp_profile"]["age"]) : $user["age"]
      ])
      ->startDiv(attributs: [
        "class" => !empty($_SESSION["error"]["profile"]["age"]) ? "error mt-10" : ""
      ], content: !empty($_SESSION["error"]["profile"]["age"]) ? $_SESSION["error"]["profile"]["age"] : "")
      ->endDiv()
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
