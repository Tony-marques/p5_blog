<?php

namespace App\services;

use App\app\Db;
use App\app\FormBuilder;
use App\models\ArticleModel;
use App\services\UtilService;

class ArticleService
{

    public static function checkCreateArticle(string $title, string $content)
    {

        // Form validation
        if (\strlen($title) < 5 || \strlen($content) < 20) {
            $_SESSION["error"] = [
                "article" => [
                    "title" => \strlen($title) < 5 ? "Votre titre doit faire au minimum 5 caractères" : "",
                    "content" => \strlen($content) < 20 ? "Votre contenu doit faire au minimum 20 caractères" : "",
                ]
            ];

            $_SESSION["tmp_article"] = [
                "title" => $title,
                "content" => $content
            ];

            return false;
        }


        \header("location: /articles");
        return true;
    }

    public function checkEditArticle(string $title, string $content, int $id)
    {
        $title = \htmlspecialchars($title);
        $content = \htmlspecialchars($content);

        // Form validation
        if (\strlen($title) < 5 || \strlen($content) < 20) {
            $_SESSION["error"] = [
                "article" => [
                    "title" => \strlen($title) < 5 ? "Votre titre doit faire au minimum 5 caractères" : "",
                    "content" => \strlen($content) < 20 ? "Votre contenu doit faire au minimum 20 caractères" : "",
                ]
            ];

            $_SESSION["tmp_article"] = [
                "title" => $title,
                "content" => $content
            ];

            \header("location: /article/edition/$id");
            return false;
        }
        return true;
    }

    public static function createForm(mixed $subject = null)
    {
//        UtilService::beautifulArray($subject);
        $CSRFToken = bin2hex(random_bytes(32));
        $_SESSION["csrf_token"] = $CSRFToken;

        $form = new FormBuilder();
        $form->startForm()
            ->startDiv(content: !empty($subject) ? "Modifier l'article {$subject->getTitle()}" : "Créer un article")
            ->endDiv()
            ->startDiv([
                "class" => "form-container"
            ])
            ->startDiv([
                "class" => "form-group"
            ])
            ->setLabel(!empty($subject) ? "title" : "", !empty($subject) ? "Titre" : "")
            ->setInput("text", "title", [
                "value" => (!empty($_SESSION["tmp_article"]["title"])) ?
                    ($_SESSION["tmp_article"]["title"])
                    : (!empty($subject) ? $subject->getTitle() : ""),
                "placeholder" => !empty($subject) ? "" : "Titre"
            ])
            ->startDiv(attributs: [
                "class" => !empty($_SESSION["error"]["article"]["title"]) ? "error mt-10" : ""
            ], content: !empty($_SESSION["error"]["article"]["title"]) ? $_SESSION["error"]["article"]["title"] : "")
            ->endDiv()
            ->endDiv()
            ->startDiv([
                "class" => "form-group"
            ])
            ->setLabel(!empty($subject) ? "content" : "", !empty($subject) ? "Contenu" : "")
            ->setTextarea(
                "content",
                (!empty($_SESSION["tmp_article"]["content"])) ?
                    ($_SESSION["tmp_article"]["content"])
                    : (!empty($subject) ? $subject->getContent() : ""),
                [
                    "rows" => 15,
                    "placeholder" => !empty($subject) ? "" : "Contenu"
                ]
            )
            ->startDiv(attributs: [
                "class" => !empty($_SESSION["error"]["article"]["content"]) ? "error mt-10" : ""
            ], content: !empty($_SESSION["error"]["article"]["content"]) ? $_SESSION["error"]["article"]["content"] : "")
            ->endDiv()
            ->startDiv(attributs: [
                "class" => !empty($_SESSION["error"]["csrf_token"]) ? "error mt-10" : ""
            ], content: !empty($_SESSION["error"]["csrf_token"]) ? $_SESSION["error"]["csrf_token"] : "")
            ->endDiv()
            ->endDiv()
            ->endDiv()
            ->setInput("hidden", "csrf_token", [
                "value" => $_SESSION["csrf_token"]
            ])
            ->setButton($subject ? "Modifier" : "Créer", [
                "class" => "button button-primary"
            ])
            ->endForm();

        return $form;
    }

    public static function sortArticlesAsc(array $articles)
    {
        // sort article by created_at (asc)
        usort($articles, function ($a, $b) {
            return strtotime($b['created_at']) - strtotime($a['created_at']);
        });
        return $articles;
    }

}
