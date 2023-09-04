<?php

namespace App\services;

use App\app\FormBuilder;
use App\models\ArticleModel;

class ArticleService
{
  public static function findAllArticles($limit = null, $offset = 0)
  {
    $articleModel = new ArticleModel();
    if ($limit !== null) {

      $articles = $articleModel->findAll($limit, $offset);
    } else {
      $articles = $articleModel->findAll();
    }

    return $articles;
  }

  public static function findOne($id)
  {
    $id = (int)$id;
    $articleModel = new ArticleModel();
    $article = $articleModel->findOne($id);

    return $article;
  }

  public static function sortArticlesAsc(array $articles)
  {
    // sort article by created_at (asc)
    usort($articles, function ($a, $b) {
      return strtotime($b['created_at']) - strtotime($a['created_at']);
    });
    return $articles;
  }

  public static function createArticle(string $title, string $content)
  {
    // Sanitize fields
    $title = \htmlspecialchars($title);
    $content = \htmlspecialchars($content);

    // Form validation
    if (\strlen($title) < 5 || \strlen($content) < 20) {
      $_SESSION["error"] = [
        "article" => [
          "title" => \strlen($title) < 5 ? "Votre titre doit faire au minimum 5 caractères" : "",
          "content" =>  \strlen($content) < 20 ? "Votre contenu doit faire au minimum 20 caractères" : "",
        ]
      ];

      $_SESSION["tmp_article"] = [
        "title" => $title,
        "content" => $content
      ];

      \header("location: /article/nouveau");
      exit;
    }

    $article = new ArticleModel();
    $article->setTitle($title)
      ->setContent($content)
      ->setAuthor($_SESSION["user"]["firstname"])
      ->setUserId($_SESSION["user"]["id"]);

    $article->create();

    \header("location: /articles");
    exit;
  }


  public static function editArticle(string $title, string $content, int $id)
  {
    $title = \htmlspecialchars($title);
    $content = \htmlspecialchars($content);

    // Form validation
    if (\strlen($title) < 5 || \strlen($content) < 20) {
      $_SESSION["error"] = [
        "article" => [
          "title" => \strlen($title) < 5 ? "Votre titre doit faire au minimum 5 caractères" : "",
          "content" =>  \strlen($content) < 20 ? "Votre contenu doit faire au minimum 20 caractères" : "",
        ]
      ];

      $_SESSION["tmp_article"] = [
        "title" => $title,
        "content" => $content
      ];

      // UtilService::beautifulArray($_SESSION["tmp_article"]);
      // exit;

      \header("location: /article/edition/$id");
      exit;
    }

    $article = new ArticleModel();
    $article->setTitle($title)
      ->setContent($content);

    $article->update($id);
    \header("location: /articles");
    exit;
  }

  public static function deleteArticle(int $id)
  {
    $articleModel = new ArticleModel();
    // Find one article
    $article = self::findOne($id);

    // If not the same user, redirect
    if ($article["user_id"] != $_SESSION["user"]["id"]) {
      \header("location: /article/$id");
      exit();
    }

    // Delete article
    $articleModel->delete($id);

    // Redirect after deleted article
    \header("location: /articles");
    exit();
  }

  public static function createForm(mixed $subject = null)
  {
    $form = new FormBuilder();
    $form->startForm()
      ->startDiv(content: !empty($subject) ? "Modifier l'article {$subject['title']}" : "Créer un article")
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
          : (!empty($subject["title"]) ? $subject["title"] : ""),
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
          : (!empty($subject["content"]) ? $subject["content"] : ""),
        [
          "rows" => 15,
          "placeholder" => !empty($subject) ? "" : "Contenu"
        ]
      )
      ->startDiv(attributs: [
        "class" => !empty($_SESSION["error"]["article"]["content"]) ? "error mt-10" : ""
      ], content: !empty($_SESSION["error"]["article"]["content"]) ? $_SESSION["error"]["article"]["content"] : "")
      ->endDiv()
      ->endDiv()
      ->endDiv()
      ->setButton($subject ? "Modifier" : "Créer", [
        "class" => "button button-primary"
      ])
      ->endForm();

    return $form;
  }
}
