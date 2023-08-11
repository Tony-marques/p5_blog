<?php

namespace App\controllers;

use PDO;
use DateTime;
use App\app\Db;
use App\app\FormBuilder;
use App\services\Auth;
use App\models\ArticleModel;
use App\services\FormatDate;

class ArticleController extends AbstractController
{
  /**
   * all articles show
   */
  public function index()
  {
    // echo "classe testcontroller - méthode index";
    $articleModel = new ArticleModel();
    $articles = $articleModel->findAll();


    $dateFormat = new FormatDate();
    // $newDate = [];
    foreach ($articles as $article) {
      $newDate[] = $dateFormat->format($article["created_at"]);
    }
    // echo "<pre>";
    // var_dump($newDate);
    // echo "</pre>";

    return $this->render("articles/index", [
      "articles" => $articles,
      "dates" => $newDate
    ]);
  }

  /**
   * one article
   */
  public function showOne(string $id)
  {
    $id = (int)$id;
    // echo \gettype($id);
    // echo "classe testcontroller - méthode index";
    $articleModel = new ArticleModel();
    $article = $articleModel->findOne($id);

    // var_dump($article[2]);

    return $this->render("articles/show_one", [
      "article" => $article
    ]);
  }

  /**
   * Create new article
   */
  public function new()
  {
    Auth::isLogOut();

    $form = new FormBuilder();
    $form->startForm(attributs: [
      "class" => "test tessssss",
      "required" => "true"
    ])
      ->startDiv([
        "class" => "form-container"
      ])
      ->startDiv([
        "class" => "form-group"
      ])
      ->setLabel("title", "Titre")
      ->setInput(type: "text", name: "title")
      ->endDiv()
      ->startDiv([
        "class" => "form-group"
      ])
      ->setLabel("content", "Contenu")
      ->setTextarea(name: "content", attributs: [
        "rows" => 10
      ])
      ->endDiv()
      ->endDiv()
      ->setButton("Créer l'article", [
        "class" => "button button-primary"
      ])
      ->endForm();


    if (isset($_POST["submit"])) {
      if (FormBuilder::validate($_POST, ["title", "content"])) {

        $title = \htmlspecialchars($_POST["title"]);
        $content = \htmlspecialchars($_POST["content"]);
        $created_at = new DateTime();
        $created_at = $created_at->format("m/d/y");
        $updated_at = new DateTime();
        $updated_at = $updated_at->format("m/d/y");

        $article = new ArticleModel();
        $article->setTitle($title)
          ->setContent($content)
          ->setAuthor("tony");


        $article->create($article);
        \header("location: /articles");
      }
    }

    return $this->render("articles/new", ["form" => $form->create()]);
  }

  /**
   * Edit this article
   */
  public function edit($id)
  {
    Auth::isLogOut();

    $id = (int)$id;
    // echo \gettype($id);
    $articleModel = new ArticleModel();
    $article = $articleModel->findOne($id);

    if($article["user_id"] != $_SESSION["user"]["id"]){
      \header("location: /articles");
    }

    $form = new FormBuilder();
    $form->startForm()
      ->setInput("text", "title", [
        "value" => $article["title"]
      ])
      ->setTextarea("content", $article["content"])
      ->setButton("Modifier")
      ->endForm();

    if (isset($_POST["submit"])) {
      if (FormBuilder::validate($_POST, ["title", "content"])) {

        $title = \htmlspecialchars($_POST["title"]);
        $content = \htmlspecialchars($_POST["content"]);

        $article = new ArticleModel();
        $article->setTitle($title)
          ->setContent($content);

        $article->update($article, $id);
        \header("location: /article/edition/$id");
      }
    }

    return $this->render("articles/edition", [
      "article" => $article,
      "form" => $form->create()
    ]);
  }

  /**
   * Delete this article
   */
  public function delete($id)
  {
    Auth::isLogOut();

    $articleModel = new ArticleModel();
    $articleModel->delete($id);
  }
}
