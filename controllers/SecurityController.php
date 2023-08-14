<?php


namespace App\controllers;

use App\app\FormBuilder;
use App\models\UserModel;
use App\services\Auth;

class SecurityController extends AbstractController
{

  public function logout()
  {
    if (!isset($_SESSION["user"])) {
      \header("location: /");
    }

    unset($_SESSION["user"]);
    \header("location: /");
  }

  public function login()
  {
    Auth::checkUserLogged();


    if (isset($_POST["submit"])) {
      if (\filter_var($_POST["email"], \FILTER_VALIDATE_EMAIL) == false) {
        $_SESSION["error"] = [
          "email" => "Format d'adresse email incorrect !"
        ];
        // echo "email invalide";
        \header("location: /connexion");
        exit;
      }
      if (FormBuilder::validate($_POST, ["email", "password"])) {
        $_POST = \filter_input_array(INPUT_POST, [
          "email" => \FILTER_SANITIZE_EMAIL,
          "password" => \FILTER_SANITIZE_FULL_SPECIAL_CHARS
        ]);



        $userModel = new UserModel();
        $user = $userModel->findByEmail($_POST["email"]);
        print_r($_POST);
        // exit;
        if (!$user) {
          $_SESSION["error"] = [
            "login" => "Adresse e-mail ou mot de passe incorrect !"
          ];
          // echo $_SESSION["error"]["login"];
          \header("location: /connexion");
          exit;
        }



        if (\password_verify($_POST["password"], $user["password"])) {
          $_SESSION = [
            "user" => [
              "id" => $user["id"],
              "firstname" => isset($user["firstname"]) ? $user["firstname"] : "",
              "lastname" => isset($user["lastname"]) ? $user["lastname"] : "",
              "age" => isset($user["age"]) ? $user["age"] : "",
              "avatar" => isset($user["avatar"]) ? $user["avatar"] : "",
              "role" => isset($user["role"]) ? $user["role"] : "",
            ]
          ];
          \header("location: /");
          exit;
        } else {
          $_SESSION["error"] = [
            "login" => "Adresse e-mail ou mot de passe incorrect !"
          ];
          // echo $_SESSION["error"]["login"];
          \header("location: /connexion");
          exit;
        }
      }
    }


    $form = new FormBuilder();
    $form->startForm()
      ->startDiv([
        "class" => "form-container"
      ])
      ->startDiv([
        "class" => "form-group"
      ])
      ->setLabel("email", "Adresse e-mail")
      ->setInput(type: "text", name: "email")
      ->startDiv(content: isset($_SESSION["error"]["email"]) ? $_SESSION["error"]["email"] : "", attributs: [
        "class" => isset($_SESSION["error"]["email"]) ? "error mt-10" : ""
      ])
      ->endDiv()
      ->endDiv()
      ->startDiv([
        "class" => "form-group"
      ])
      ->setLabel("password", "Mot de passe")
      ->setInput(type: "password", name: "password")
      ->startDiv(content: isset($_SESSION["error"]["login"]) ? $_SESSION["error"]["login"] : "", attributs: [
        "class" => isset($_SESSION["error"]["login"]) ? "error mt-10" : ""
      ])
      ->endDiv()
      ->endDiv()

      ->endDiv()
      ->setButton("Me connecter", [
        "class" => "button-primary button-login"
      ])
      ->endForm();


    return $this->render(path: "security/login", template: "security", data: [
      "form" => $form->create()
    ]);
  }

  public function register()
  {
    Auth::checkUserLogged();

    if (isset($_POST["submit"])) {
      if (FormBuilder::validate($_POST, ["email", "password"])) {
        $_POST = \filter_input_array(INPUT_POST, [
          "email" => \FILTER_SANITIZE_EMAIL,
          "password" => \FILTER_SANITIZE_FULL_SPECIAL_CHARS
        ]);

        $hashedPassword = \password_hash($_POST["password"], \PASSWORD_ARGON2I);

        $userModel = new UserModel();
        $user = $userModel->setEmail($_POST["email"])
          ->setPassword($hashedPassword);
        $userModel->create();
      }
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
      ->setInput(type: "text", name: "firstname")
      ->endDiv()
      ->startDiv([
        "class" => "form-group"
      ])
      ->setLabel("lastname", "Nom")
      ->setInput(type: "text", name: "lastname")
      ->endDiv()
      ->startDiv([
        "class" => "form-group"
      ])
      ->setLabel("email", "Adresse e-mail")
      ->setInput(type: "text", name: "email")
      ->endDiv()
      ->startDiv([
        "class" => "form-group"
      ])
      ->setLabel("password", "Mot de passe")
      ->setInput(type: "text", name: "password")

      ->endDiv()
      ->endDiv()
      ->setButton("Créer mon compte", [
        "class" => "button-primary button-login"
      ])
      ->endForm();


    return $this->render(path: "security/register", template: "security", data: [
      "form" => $form->create()
    ]);
  }
}
