<?php


namespace App\controllers;

use App\app\FormBuilder;
use App\models\UserModel;
use App\services\AuthService;
use App\services\UtilService;

class SecurityController extends AbstractController
{

  public function logout()
  {
    if (!isset($_SESSION["user"])) {
      \header("location: /");
      exit; // test
    }

    unset($_SESSION["user"]);
    \header("location: /");
    exit; // test
  }

  /**
   * login view
   */
  public function login()
  {
    AuthService::checkUserLogged();

    // $CSRFToken = bin2hex(random_bytes(32));

    // $_SESSION["csrf_token"] = $CSRFToken;

    if (isset($_POST["submit"])) {
      if ($_SESSION["csrf_token"] != $_POST["csrf_token"]) {
        $_SESSION["error"]["csrf_token"] = "Adresse e-mail ou mot de passe incorrect !";
        \header("location: /connexion");
        exit;
      }

      // $CSRFToken = bin2hex(random_bytes(32));

      // $_SESSION["csrf_token"] = $CSRFToken;
      if (!AuthService::checkCSRFToken($_POST["csrf_token"])) {
        echo "token non valide";
        exit;
      }

      $_SESSION["temporary_user"] = [
        "email" => $_POST["email"],
      ];

      if (\filter_var($_POST["email"], \FILTER_VALIDATE_EMAIL) == false) {
        $_SESSION["error"] = [
          "email" => "Format d'adresse email incorrect !"
        ];

        \header("location: /connexion");
        exit;
      }

      $_POST = \filter_input_array(INPUT_POST, [
        "email" => \FILTER_SANITIZE_EMAIL,
        "password" => \FILTER_SANITIZE_FULL_SPECIAL_CHARS
      ]);

      $userModel = new UserModel();
      $user = $userModel->findByEmail($_POST["email"]);

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
        \header("location: /connexion");
        exit;
      }
    }
    $CSRFToken = bin2hex(random_bytes(32));

    $_SESSION["csrf_token"] = $CSRFToken;

    $form = new FormBuilder();
    $form->startForm()
      ->startDiv([
        "class" => "form-container"
      ])
      ->startDiv([
        "class" => "form-group"
      ])
      // ->setLabel("email", "Adresse e-mail")
      ->setInput(type: "text", name: "email", attributs: [
        "value" => !empty($_SESSION["temporary_user"]["email"]) ? $_SESSION["temporary_user"]["email"] : "",
        "placeholder" => "Adresse e-mail"
      ])
      ->startDiv(content: isset($_SESSION["error"]["email"]) ? $_SESSION["error"]["email"] : "", attributs: [
        "class" => isset($_SESSION["error"]["email"]) ? "error mt-10" : ""
      ])
      ->endDiv()
      ->endDiv()
      ->startDiv([
        "class" => "form-group"
      ])
      // ->setLabel("password", "Mot de passe")
      ->setInput(type: "password", name: "password", attributs: [
        "placeholder" => "Mot de passe"
      ])
      ->startDiv(content: isset($_SESSION["error"]["login"]) ? $_SESSION["error"]["login"] : "", attributs: [
        "class" => isset($_SESSION["error"]["login"]) ? "error mt-10" : ""
      ])
      ->endDiv()
      ->startDiv(content: isset($_SESSION["error"]["csrf_token"]) ? $_SESSION["error"]["csrf_token"]  : "", attributs: [
        "class" => isset($_SESSION["error"]["csrf_token"]) ? "error mt-10" : ""
      ])
      ->endDiv()
      ->endDiv()
      ->endDiv()
      ->setButton("Me connecter", [
        "class" => "button-primary button"
      ])
      ->setInput(type: "hidden", name: "csrf_token", attributs: [
        "value" => $_SESSION["csrf_token"]
      ])
      ->endForm();


    return $this->render(path: "security/login", data: [
      "form" => $form->create()
    ]);
  }

  public function register()
  {
    AuthService::checkUserLogged();

    if (isset($_POST["submit"])) {
      $passwordRegex = "^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[-+!*$@%_])([-+!*$@%_\w]{8,})$";

      $userModel = new UserModel();
      $user = $userModel->findByEmail($_POST["email"]);
      $userExist = null;
      if ($user) {
        $userExist = true;
      }

      if (
        \strlen($_POST["firstname"]) < 3
        || \strlen($_POST["lastname"]) < 3
        || !\filter_var($_POST["email"], \FILTER_VALIDATE_EMAIL)
        || !\preg_match("#$passwordRegex#", $_POST["password"])
        || $userExist
      ) {

        $_SESSION["temporary_user"] = [
          "firstname" => $_POST["firstname"],
          "lastname" => $_POST["lastname"],
          "email" => $_POST["email"],
        ];

        $_SESSION["error"] = [
          "register" => [
            "firstname" => \strlen($_POST["firstname"]) < 3 ? "Votre prénom doit faire au minimum 3 caractères" : "",
            "lastname" =>  \strlen($_POST["lastname"]) < 3 ? "Votre nom doit faire au minimum 3 caractères" : "",

            "email" => ($userExist) ? "Cet utilisateur existe déjà" : (!\filter_var($_POST["email"], \FILTER_VALIDATE_EMAIL) ? "Format incorrect pour votre adresse e-mail" : ""),

            "password" => !\preg_match("#$passwordRegex#", $_POST["password"]) ? "Votre mot de passe doit faire au minimum 8 caractères et contenir au moins une majuscule, une minuscule, un chiffre et un caractère spécial" : "",
          ]
        ];



        \header("location: /inscription");
        exit;
      }




      // if (FormBuilder::validate($_POST, ["email", "password", "firstname", "lastname"])) {
      $_POST = \filter_input_array(INPUT_POST, [
        "email" => \FILTER_SANITIZE_EMAIL,
        "password" => \FILTER_SANITIZE_FULL_SPECIAL_CHARS,
        "firstname" => \FILTER_SANITIZE_FULL_SPECIAL_CHARS,
        "lastname" => \FILTER_SANITIZE_FULL_SPECIAL_CHARS
      ]);

      $hashedPassword = \password_hash($_POST["password"], \PASSWORD_ARGON2I);

      $userModel = new UserModel();
      $userModel->setEmail($_POST["email"])
        ->setPassword($hashedPassword)
        ->setFirstname($_POST["firstname"])
        ->setLastname($_POST["lastname"])
        ->setRole("[\"ROLE_USER\"]");

      // for ($i = 1; $i < 100; $i++) {
      //   $userModel->setEmail("test$i@gmail.com")
      //     ->setPassword("a")
      //     ->setFirstname("firstname $i")
      //     ->setLastname("lastname $i")
      //     ->setAge(\rand(18, 95))
      //     ->setRole("[\"ROLE_USER\"]");
      //     $userModel->create();
      // }

      $_SESSION["success"] = [
        "message" => "Votre compte a été créé avec succès !"
      ];
      \header("location: /connexion");
      exit;
    }

    // UtilService::beautifulArray($_SESSION);

    $form = new FormBuilder();
    $form->startForm()
      ->startDiv([
        "class" => "form-container"
      ])
      ->startDiv([
        "class" => "form-group"
      ])
      // ->setLabel("firstname", "Prénom")
      ->setInput(
        type: "text",
        name: "firstname",
        attributs: [
          "value" => !empty($_SESSION["temporary_user"]["firstname"]) ? $_SESSION["temporary_user"]["firstname"] : "",
          "placeholder" => "Prénom",
          "autocomplete" => "off"
        ]
      )
      ->startDiv(attributs: [
        "class" => !empty($_SESSION["error"]["register"]["firstname"]) ? "error mt-10" : ""
      ], content: !empty($_SESSION["error"]["register"]["firstname"]) ? $_SESSION["error"]["register"]["firstname"] : "")
      ->endDiv()
      ->endDiv()
      ->startDiv([
        "class" => "form-group"
      ])
      // ->setLabel("lastname", "Nom")
      ->setInput(
        type: "text",
        name: "lastname",
        attributs: [
          "value" => !empty($_SESSION["temporary_user"]["lastname"]) ? $_SESSION["temporary_user"]["lastname"] : "",
          "placeholder" => "Nom"
        ]
      )
      ->startDiv(attributs: [
        "class" => !empty($_SESSION["error"]["register"]["lastname"]) ? "error mt-10" : ""
      ], content: !empty($_SESSION["error"]["register"]["lastname"]) ? $_SESSION["error"]["register"]["lastname"] : "")
      ->endDiv()
      ->endDiv()
      ->startDiv([
        "class" => "form-group"
      ])
      // ->setLabel("email", "Adresse e-mail")
      ->setInput(
        type: "text",
        name: "email",
        attributs: [
          "value" => !empty($_SESSION["temporary_user"]["email"]) ? $_SESSION["temporary_user"]["email"] : "",
          "placeholder" => "Adresse e-mail"
        ]
      )
      ->startDiv(attributs: [
        "class" => !empty($_SESSION["error"]["register"]["email"]) ? "error mt-10" : ""
      ], content: !empty($_SESSION["error"]["register"]["email"]) ? $_SESSION["error"]["register"]["email"] : "")
      ->endDiv()
      ->endDiv()
      ->startDiv([
        "class" => "form-group"
      ])
      // ->setLabel("password", "Mot de passe")
      ->setInput(type: "text", name: "password", attributs: [
        "value" => "",
        "placeholder" => "Mot de passe"
      ])
      ->startDiv(attributs: [
        "class" => !empty($_SESSION["error"]["register"]["password"]) ? "error mt-10" : ""
      ], content: !empty($_SESSION["error"]["register"]["password"]) ? $_SESSION["error"]["register"]["password"] : "")
      ->endDiv()
      ->endDiv()
      ->endDiv()
      ->setButton("Créer mon compte", [
        "class" => "button-primary button"
      ])
      ->endForm();


    return $this->render(path: "security/register", data: [
      "form" => $form->create()
    ]);
  }

  public function allUsers()
  {
    AuthService::checkAdmin(pathToRedirect: "/");

    $userModel = new UserModel();
    // $users = $userModel->findAll();
    $users = $userModel->findBy(["role" => "[\"ROLE_USER\"]"]);

    // UtilService::beautifulArray($users);
    // exit;

    return $this->render(path: "security/allUsers", data: [
      "users" => $users
    ]);
  }
}
