<?php

namespace App\services;

use App\app\Db;
use App\app\FormBuilder;
use App\models\CommentModel;

class CommentService extends AbstractService
{
    private Db $db;

    public function __construct(){
        $this->db = Db::getInstance();
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


//        UtilService::beautifulArray($values);
        $stmt = $this->db->prepare($sql);
        $stmt->execute($values);
//        $stmt = $this->request($sql, $values);
//        UtilService::beautifulArray($stmt->fetchAll());
        return $stmt->fetchAll();
    }

//  public static function findUserAndArticle(array $arr)
//  {
//    $commentModel = new CommentModel();
//    $comment = $commentModel->findUserCommentArticle($arr);
//
//    return $comment;
//  }

    public static function createComment(int $id, string $comment)
    {
//    $isAdmin = AuthService::isAdmin();
        $content = \htmlspecialchars($comment);
        $commentModel = new CommentModel();
        $comment = $commentModel->setContent($content)
            ->setArticleId($id)
            // if is admin, comment is directly published
            ->setPublished($isAdmin ? 1 : 0)
            ->setUserId($_SESSION["user"]["id"]);

        $_SESSION["comment"]["message"] = "Commentaire soumis avec succès.";

        $comment->create();
        \header("location: /article/$id");
        return;
    }

    public static function sortCommentAsc(array $comments)
    {
        usort($comments, function ($a, $b) {
            return strtotime($b['created_at']) - strtotime($a['created_at']);
        });

        return $comments;
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
}
