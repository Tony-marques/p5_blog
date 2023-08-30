<?php

namespace App\controllers;

use App\app\FormBuilder;
use App\services\UtilService;

class HomeController extends AbstractController
{
  public function index()
  {

    $form = new FormBuilder();
    $form->startForm()
      ->startDiv(attributs: [
        "class" => "form-input"
      ])
      ->setInput(type: "text", name: "name", attributs: [
        "placeholder" => "Nom",
        "class" => "input-contact"
      ])
      ->setInput(type: "text", name: "email", attributs: [
        "placeholder" => "Email",
        "class" => "input-contact"
      ])
      ->endDiv()
      ->setTextarea(name: "message", attributs: [
        "placeholder" => "Message",
        "class" => "textarea-contact",
        "rows" => 5
      ])
      ->setButton("Envoyer", [
        "class" => "button button-primary"
      ])
      ->endForm();


    return $this->render("home/index", [
      "form" => $form->create()
    ]);
  }
}
