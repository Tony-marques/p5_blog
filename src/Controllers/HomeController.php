<?php

namespace App\Controllers;

use App\App\FormBuilder;
use App\Controllers\AbstractController;


class HomeController extends AbstractController
{
  /**
   * Home page
   */
  public function index()
  {
    if (isset($_POST["submit"])) {
      if ($_SESSION["csrf_token"] !== $_POST["csrf_token"]) {
        $_SESSION["error"]["csrf_token"] = "Il y a un problème avec votre token";

        \header("location: /");
        return;
      }

      $email = \htmlspecialchars($_POST["email"]);
      $name = \htmlspecialchars($_POST["name"]);
      $message = \htmlspecialchars($_POST["message"]);
      if (
        !\filter_var($email, \FILTER_VALIDATE_EMAIL)
        || \strlen($name) <= 3
        || \strlen($message) <= 20
      ) {
        $_SESSION["contact"] = [
          "error" => [
            "email" => !\filter_var($email, \FILTER_VALIDATE_EMAIL) ? "Format d'email incorrect." : "",
            "name" => \strlen($name) <= 3 ? "Votre nom doit faire au minimum 3 caractères." : "",
            "message" => \strlen($message) <= 20 ? "Votre message doit faire au minimum 20 caractères." : ""
          ],
          "tmp_user" => [
            "email" => $email,
            "name" => $name,
            "message" => $message
          ]
        ];

        \header("location: /");
        return;
      }

      $headers = [
        "From" => $email
      ];
      \mail("tony.marques@live.fr",  "Mail test", $message, $headers);
      $_SESSION["contact"]["success"] = "Votre message a été envoyé avec succès.";
    }
    $CSRFToken = bin2hex(random_bytes(32));
    $_SESSION["csrf_token"] = $CSRFToken;

    $form = new FormBuilder();
    $form->startForm()
      ->startDiv(attributs: [
        "class" => "form-input"
      ])
      ->startDiv(attributs: [
        "class" => "name-field"
      ])
      ->setInput(type: "text", name: "name", attributs: [
        "placeholder" => "Nom",
        "value" => !empty($_SESSION["contact"]["tmp_user"]["name"]) ? $_SESSION["contact"]["tmp_user"]["name"] : "",
        "class" => "input-contact"
      ])
      ->startDiv(
        attributs: [
          "class" => !empty($_SESSION["contact"]["error"]["name"]) ? "error mt-10" : ""
        ],
        content: !empty($_SESSION["contact"]["error"]["name"]) ? $_SESSION["contact"]["error"]["name"] : ""
      )
      ->endDiv()
      ->endDiv()

      ->startDiv(attributs: [
        "class" => "email-field"
      ])
      ->setInput(type: "text", name: "email", attributs: [
        "placeholder" => "Email",
        "value" => !empty($_SESSION["contact"]["tmp_user"]["email"]) ? $_SESSION["contact"]["tmp_user"]["email"] : "",
        "class" => "input-contact"
      ])
      ->startDiv(
        attributs: [
          "class" => !empty($_SESSION["contact"]["error"]["email"]) ? "error mt-10" : ""
        ],
        content: !empty($_SESSION["contact"]["error"]["email"]) ? $_SESSION["contact"]["error"]["email"] : ""
      )
      ->endDiv()
      ->endDiv()
      ->endDiv()
      ->startDiv(attributs: [
        "class" => "message"
      ])
      ->setTextarea(
        name: "message",
        attributs: [
          "placeholder" => "Message",
          "class" => "textarea-contact",
          "rows" => 5
        ],
        content: !empty($_SESSION["contact"]["tmp_user"]["message"]) ? $_SESSION["contact"]["tmp_user"]["message"] : ""
      )
      ->startDiv(
        attributs: [
          "class" => !empty($_SESSION["contact"]["error"]["message"]) ? "error mt-10" : ""
        ],
        content: !empty($_SESSION["contact"]["error"]["message"]) ? $_SESSION["contact"]["error"]["message"] : ""
      )
      ->endDiv()
      ->endDiv()
      ->setInput("hidden", "csrf_token", attributs: [
        "value" => $_SESSION["csrf_token"]
      ])
      ->setButton("Envoyer", [
        "class" => "button button-primary"
      ])
      ->startDiv(
        content: !empty($_SESSION["contact"]["success"]) ? $_SESSION["contact"]["success"] : "",
        attributs: [
          "class" => !empty($_SESSION["contact"]["success"]) ? "success mt-10" : ""
        ]
      )
      ->endDiv()
      ->startDiv(
        content: !empty($_SESSION["error"]["csrf_token"]) ? $_SESSION["error"]["csrf_token"] : "",
        attributs: [
          "class" => !empty($_SESSION["error"]["csrf_token"]) ? "error mt-10" : ""
        ]
      )
      ->endDiv()
      ->endForm();

    return $this->render("home/index", "accueil", [
      "form" => $form->create()
    ]);
  }
}
