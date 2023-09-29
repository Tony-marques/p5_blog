<?php

namespace App\Services;

use App\App\FormBuilder;

class CommentService
{
    public static function createForm()
    {
        // Create form for comments
        $form = new FormBuilder();
        $form->startForm(attributs: [
            "class" => "mt-30 add-comment",
            "required" => "true"
        ])
            ->startDiv([
                "class" => "form-container"
            ])
            ->startDiv([
                "class" => "form-group"
            ])
            ->setTextarea(name: "comment", attributs: [
                "placeholder" => "Ecrit ton commentaire",
                "rows" => 5,
                "class" => ""
            ])
            ->endDiv()
            ->startDiv(
                attributs: [
                    "class" => !empty($_SESSION["comment"]["message"]) ? "success-comment" : ""
                ],
                content: !empty($_SESSION["comment"]["message"]) ? $_SESSION["comment"]["message"] : ""
            )
            ->endDiv()
            ->endDiv()
            ->setButton("Soumettre mon commentaire", [
                "class" => "button button-primary"
            ])
            ->endForm();

        return $form;
    }
}
