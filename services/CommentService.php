<?php 

namespace App\services;

use App\app\FormBuilder;
use App\models\CommentModel;

class CommentService{

  public static function findBy(array $arr){
    $commentModel = new CommentModel();
    $comment = $commentModel->findBy($arr);

    return $comment;
  }

  public static function createForm(){
        // Create form for comments
        $form = new FormBuilder();
        $form->startForm(attributs: [
          "class" => "mt-30",
          "required" => "true"
        ])
          ->startDiv([
            "class" => "form-container"
          ])
          ->startDiv([
            "class" => "form-group"
          ])
          ->setLabel("commentaire", "Commentaire")
          ->setTextarea(name: "comment", attributs: [
            "placeholder" => "Ecrit ton commentaire",
            "rows" => 5
          ])
          ->endDiv()
    
          ->endDiv()
          ->setButton("Soumettre mon commentaire", [
            "class" => "button button-primary"
          ])
          ->endForm();

          return $form;
  }
}