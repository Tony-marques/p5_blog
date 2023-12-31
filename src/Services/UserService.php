<?php

namespace App\Services;

use App\App\Db;
use App\App\FormBuilder;
use App\Models\User;

class UserService
{
    /**
     * check field for profile form
     * @param array $post
     * @return bool
     */
    public static function checkFields(array $post)
  {
    if (
      \strlen($post["firstname"]) < 3
      || \strlen($post["lastname"]) < 3
      || (!\filter_var($post["age"], \FILTER_VALIDATE_INT) || $post["age"] > 100 || $post["age"] <= 0)
    ) {
      return false;
    } else {
      return true;
    }
  }

    /**
     * If checkFields function return false, add error on PHP session
     * @param array $post
     * @return void
     */
    public static function createErrorSessionFields(array $post)
  {
    $_SESSION["error"] = [
      "profile" => [
        "firstname" => \strlen($post["firstname"]) < 3 ? "Votre prénom doit faire au minimum 3 caractères" : "",
        "lastname" =>  \strlen($post["lastname"]) < 3 ? "Votre nom doit faire au minimum 3 caractères" : "",
        "age" => (((int)$post["age"] > 100 || (int)$post["age"] <= 0) ? "Votre age doît être comprit entre 1 et 100 ans" : ""),
      ]
    ];
  }

    /**
     * Create temporary profile variables
     * @param array $post
     * @return void
     */
    public static function createTmpProfileSession(array $post)
  {
    $_SESSION["tmp_profile"] = [
        "firstname" => filter_var($post["firstname"], FILTER_SANITIZE_FULL_SPECIAL_CHARS),
        "lastname" => filter_var($post["lastname"], FILTER_SANITIZE_FULL_SPECIAL_CHARS),
        "age" => filter_var($post["age"], FILTER_SANITIZE_FULL_SPECIAL_CHARS),
    ];
  }

    /**
     * Create form for profile page
     * @param array $session
     * @param User $user
     * @return FormBuilder
     */
    public static function createForm(array $session, User $user)
  {
    $CSRFToken = bin2hex(random_bytes(32));
    $_SESSION["csrf_token"] = $CSRFToken;

    $form = new FormBuilder();
    $form->startForm(attributs: [
      "enctype" => "multipart/form-data"
    ])->startDiv([
      "class" => "form-container"
    ])->startDiv([
      "class" => "form-group"
    ])
      ->setLabel("profil_picture", "Photo de profil")
      ->setInput(type: "file", name: "profil_picture", attributs: [
        "accept" => "image/webp, image/png, image/jpeg, image/jpg"
      ])
      ->startDiv(attributs: [
        "class" => !empty($session["image"]["error"]) ? "error mt-10" : ""
      ], content: !empty($session["image"]["error"]) ? $session["image"]["error"] : "")
      ->endDiv()
      ->endDiv()
      ->startDiv([
        "class" => "form-group"
      ])
      ->setLabel("firstname", "Prénom")
      ->setInput(type: "text", name: "firstname", attributs: [
        "value" => !empty($session["error"]["profile"]["firstname"]) ? ($session["tmp_profile"]["firstname"]) : $user->getFirstname()
      ])
      ->startDiv(attributs: [
        "class" => !empty($session["error"]["profile"]["firstname"]) ? "error mt-10" : ""
      ], content: !empty($session["error"]["profile"]["firstname"]) ? $session["error"]["profile"]["firstname"] : "")
      ->endDiv()
      ->endDiv()
      ->startDiv([
        "class" => "form-group"
      ])
      ->setLabel("lastname", "Nom")
      ->setInput(type: "text", name: "lastname", attributs: [
        "value" => !empty($session["error"]["profile"]["lastname"]) ? ($session["tmp_profile"]["lastname"]) : $user->getLastname()
      ])
      ->startDiv(attributs: [
        "class" => !empty($session["error"]["profile"]["lastname"]) ? "error mt-10" : ""
      ], content: !empty($session["error"]["profile"]["lastname"]) ? $session["error"]["profile"]["lastname"] : "")
      ->endDiv()
      ->endDiv()
      ->startDiv([
        "class" => "form-group"
      ])
      ->setLabel("age", "Age")
      ->setInput(type: "number", name: "age", attributs: [
        "value" => !empty($session["error"]["profile"]["age"]) ? ($session["tmp_profile"]["age"]) : $user->getAge()
      ])
      ->startDiv(attributs: [
        "class" => !empty($session["error"]["profile"]["age"]) ? "error mt-10" : ""
      ], content: !empty($session["error"]["profile"]["age"]) ? $session["error"]["profile"]["age"] : "")
      ->endDiv()
      ->endDiv()
      ->startDiv(
        attributs: [
          "class" => "success-profile"
        ],
        content: !empty($_SESSION["profile"]["message"]) ? $_SESSION["profile"]["message"] : ""
      )
      ->endDiv()
      ->startDiv(
        attributs: [
          "class" => !empty($_SESSION["error"]["csrf_token"]) ? "error mt-10" : ""
        ],
        content: !empty($_SESSION["error"]["csrf_token"]) ? $_SESSION["error"]["csrf_token"] : ""
      )
      ->endDiv()
      ->endDiv()
      ->setInput("hidden", "csrf_token", [
        "value" => $_SESSION["csrf_token"]
      ])
      ->setButton("Modifier mon profil", [
        "class" => "button button-primary button-login"
      ])
      ->endForm();

    return $form;
  }
}
