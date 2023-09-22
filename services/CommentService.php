<?php

namespace App\services;

use App\app\Db;
use App\app\FormBuilder;
use App\models\CommentModel;

class CommentService
{
    private Db $db;

    public function __construct()
    {
        $this->db = Db::getInstance();
    }

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
    public function findBy(array $arr)
    {

        $keys = [];
        $values = [];

        foreach ($arr as $key => $value) {
            $keys[] = "$key = ?";
            $values[] = $value;
        }

        $list_keys = implode(" AND ", $keys);

        $sql = "SELECT * FROM comments WHERE $list_keys";


        $stmt = $this->db->prepare($sql);
        $stmt->execute($values);

        return $stmt->fetchAll();
    }

}
