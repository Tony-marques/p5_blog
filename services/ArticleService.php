<?php

namespace App\services;

use App\app\FormBuilder;
use App\models\ArticleModel;

class ArticleService
{
  public static function findAllArticles()
  {
    $articleModel = new ArticleModel();
    $articles = $articleModel->findAll();

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
    $title = \htmlspecialchars($title);
    $content = \htmlspecialchars($content);

    $article = new ArticleModel();
    $article->setTitle($title)
      ->setContent($content)
      ->setAuthor($_SESSION["user"]["firstname"])
      ->setUser_id($_SESSION["user"]["id"]);

    $article->create();

    \header("location: /articles");
  }

  public static function editArticle(string $title, string $content, int $id)
  {
    $title = \htmlspecialchars($title);
    $content = \htmlspecialchars($content);

    $article = new ArticleModel();
    $article->setTitle($title)
      ->setContent($content);

    $article->update($id);
    \header("location: /articles");
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
      ->startDiv([
        "class" => "form-container"
      ])
      ->startDiv([
        "class" => "form-group"
      ])
      ->setLabel("title", "Titre")
      ->setInput("text", "title", [
        "value" => isset($subject["title"]) ? $subject["title"] : ""
      ])
      ->endDiv()
      ->startDiv([
        "class" => "form-group"
      ])
      ->setLabel("content", "Contenu")
      ->setTextarea("content", isset($subject["content"]) ? $subject["content"] : "", [
        "rows" => 15
      ])
      ->endDiv()
      ->endDiv()
      ->setButton($subject ? "Modifier" : "Créer", [
        "class" => "button button-primary"
      ])
      ->endForm();
    // $form = new FormBuilder();
    // $form->startForm(attributs: [
    //   "class" => "test tessssss",
    //   "required" => "true"
    // ])
    //   ->startDiv([
    //     "class" => "form-container"
    //   ])
    //   ->startDiv([
    //     "class" => "form-group"
    //   ])
    //   ->setLabel("title", "Titre")
    //   ->setInput(type: "text", name: "title")
    //   ->endDiv()
    //   ->startDiv([
    //     "class" => "form-group"
    //   ])
    //   ->setLabel("content", "Contenu")
    //   ->setTextarea(name: "content", attributs: [
    //     "rows" => 10
    //   ])
    //   ->endDiv()
    //   ->endDiv()
    //   ->setButton("Créer l'article", [
    //     "class" => "button button-primary"
    //   ])
    //   ->endForm();

    return $form;
  }
}
