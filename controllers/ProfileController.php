<?php

namespace App\controllers;

use App\app\FormBuilder;
use App\models\UserModel;

class ProfileController extends AbstractController
{


  public function edit($id)
  {
    $id = (int)$id;
    $userModel = new UserModel();
    $user = $userModel->findOne($id);

    if($user["id"] != $_SESSION["user"]["id"]){
      echo "différents";
      header("location: /profil/edition/{$_SESSION['user']['id']}");
      exit;
    }

    if (isset($_POST["submit"])) {
      $user = $userModel->setAge($_POST["age"])
        ->setFirstname($_POST["firstname"])
        ->setLastname($_POST["lastname"])
        ->setAvatar($_POST["avatar"]);

        $user->update($user, $id);
        \header("location: /profil/edition/$id");
    }

    $form = new FormBuilder();
    $form->startForm()
      ->startDiv([
        "class" => "form-container"
      ])
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
      ->startDiv([
        "class" => "form-group"
      ])
      ->setLabel("avatar", "Avatar")
      ->setInput(type: "text", name: "avatar", attributs: [
        "value" => isset($user["avatar"]) ? $user["avatar"] : ""
      ])

      ->endDiv()
      ->endDiv()
      ->setButton("Modifier mon profil", [
        "class" => "button-primary button-login"
      ])
      ->endForm();

    return $this->render("profile/edit", [
      "form" => $form->create()
    ]);
  }
}
