<?php

namespace App\Services;

use App\App\FormBuilder;

class ArticleService
{

    /**
     * Check input value for create article
     * @param string $title
     * @param string $content
     * @param string $chapo
     * @return bool
     */
    public static function checkCreateArticle(string $title, string $content, string $chapo)
    {
        // Form validation
        if (\strlen($title) < 5 || \strlen($content) < 20 || \strlen($chapo) < 10) {
            $_SESSION["error"] = [
                "article" => [
                    "title" => \strlen($title) < 5 ? "Votre titre doit faire au minimum 5 caractères" : "",
                    "content" => \strlen($content) < 20 ? "Votre contenu doit faire au minimum 20 caractères" : "",
                    "chapo" => \strlen($chapo) < 10 ? "Votre chapo doit faire au minimum 10 caractères" : ""
                ]
            ];

            $_SESSION["tmp_article"] = [
                "title" => $title,
                "content" => $content,
                "chapo" => $chapo
            ];

            return false;
        }


        \header("location: /articles");
        return true;
    }

    /**
     * Check input value for edit article
     * @param string $title
     * @param string $content
     * @param string $chapo
     * @param int $id
     * @return bool
     */
    public function checkEditArticle(string $title, string $content, string $chapo, int $id)
    {
        $title = \htmlspecialchars($title);
        $content = \htmlspecialchars($content);
        $chapo = \htmlspecialchars($chapo);

        // Form validation
        if (\strlen($title) < 5 || \strlen($content) < 20 || \strlen($chapo) < 10) {
            $_SESSION["error"] = [
                "article" => [
                    "title" => \strlen($title) < 5 ? "Votre titre doit faire au minimum 5 caractères" : "",
                    "content" => \strlen($content) < 20 ? "Votre contenu doit faire au minimum 20 caractères" : "",
                    "chapo" => \strlen($chapo) < 10 ? "Votre chapo doit faire au minimum 10 caractères" : ""
                ]
            ];

            $_SESSION["tmp_article"] = [
                "title" => $title,
                "content" => $content,
                "chapo" => $chapo
            ];

            \header("location: /article/edition/$id");
            return false;
        }
        return true;
    }

    /**
     * Create form for create/edit article
     * @param mixed|null $subject
     * @return FormBuilder
     * @throws \Exception
     */
    public static function createForm(mixed $subject = null)
    {
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
            ->endDiv()->startDiv([
                "class" => "form-group"
            ])
            ->setLabel(!empty($subject) ? "Chapo" : "", !empty($subject) ? "Chapo" : "")
            ->setTextarea(
                "chapo",
                (!empty($_SESSION["tmp_article"]["chapo"])) ?
                    ($_SESSION["tmp_article"]["chapo"])
                    : (!empty($subject) ? $subject->getChapo() : ""),
                [
                    "rows" => 3,
                    "placeholder" => !empty($subject) ? "" : "Chapo"
                ]
            )
            ->startDiv(attributs: [
                "class" => !empty($_SESSION["error"]["article"]["chapo"]) ? "error mt-10" : ""
            ], content: !empty($_SESSION["error"]["article"]["chapo"]) ? $_SESSION["error"]["article"]["chapo"] : "")
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
}
