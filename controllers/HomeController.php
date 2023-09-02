<?php

namespace App\controllers;

use App\app\FormBuilder;
use App\services\UtilService;

class HomeController extends AbstractController
{
  public function index()
  {

    if (isset($_POST["submit"])) {
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
        exit;
      }

      $headers = [
        "From" => $email
      ];
      \mail("tony.marques@live.fr",  "Mail test", $message, $headers);
      $_SESSION["contact"]["success"] = "Votre message a été envoyé avec succès.";
    }

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
      ->endForm();


    return $this->render("home/index", "accueil", [
      "form" => $form->create()
    ]);
  }
}
