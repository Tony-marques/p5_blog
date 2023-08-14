<?php

namespace App\controllers;

use PDO;
use DateTime;
use App\app\Db;
use App\app\FormBuilder;
use App\services\Auth;
use App\models\ArticleModel;
use App\models\CommentModel;
use App\models\UserModel;
use App\services\ArticleService;
use App\services\CommentService;
use App\services\FormatDate;
use App\services\UserService;
use App\services\Utils;

class ArticleController extends AbstractController
{
  /**
   * all articles show
   */
  public function index()
  {
    $articles = ArticleService::findAllArticles();
    $articlesSorted = ArticleService::sortArticlesAsc($articles);

    return $this->render("articles/index", [
      "articles" => $articlesSorted,
    ]);
  }

  /**
   * one article
   */
  public function showOne(string $id)
  {
    $id = (int)$id;

    $article = ArticleService::findOne($id);

    // Fetch comment to database
    $validateComments = CommentService::findBy(["article_id" => $id, "published" => true]);
    $allComments = CommentService::findBy(["article_id" => $id]);

    // Check if user is login
    if (isset($_SESSION["user"])) {
      // $userModel = new UserModel();
      // $currentUser = $userModel->findOne($_SESSION["user"]["id"]);
      $currentUser = UserService::findOne($_SESSION["user"]["id"]);
      $isAdmin = Auth::isAdmin();

    } else {
      $isAdmin = false;
      $currentUser = null;
    }


    // // Create form for comments
    $commentForm = CommentService::createForm();

    // Create comment
    if (isset($_POST["submit"])) {
      if (FormBuilder::validate($_POST, ["comment"])) {
        // echo "ok";
        $content = \htmlspecialchars($_POST["comment"]);
        $commentModel = new CommentModel();
        $comment = $commentModel->setContent($content)
          ->setArticle_id($id)
          // if is admin, comment is directly published
          ->setPublished($isAdmin ? 1 : 0)
          ->setUser_id($_SESSION["user"]["id"]);

        $comment->create();
        \header("location: /article/$id");
        exit;
      }
    }

    // Sort all comments by asc created at
    usort($allComments, function ($a, $b) {
      return strtotime($b['created_at']) - strtotime($a['created_at']);
    });

    // Sort validate comments by asc created at
    usort($validateComments, function ($a, $b) {
      return strtotime($b['created_at']) - strtotime($a['created_at']);
    });

    return $this->render("articles/show_one", [
      "article" => $article,
      "commentForm" => $commentForm->create(),
      "validateComments" => $validateComments,
      "allComments" => $allComments,
      "isAdmin" => $isAdmin,
      "currentUser" => $currentUser
    ]);
  }

  /**
   * Create new article
   */
  public function new()
  {
    Auth::checkUserLogOut();

    $form = ArticleService::createForm();

    if (isset($_POST["submit"])) {
      if (FormBuilder::validate($_POST, ["title", "content"])) {
        ArticleService::createArticle($_POST["title"], $_POST["content"]);
      }
    }

    return $this->render("articles/new", ["form" => $form->create()]);
  }

  /**
   * Edit this article
   */
  public function edit($id)
  {
    Auth::checkUserLogOut();

    // Find one article with $id params
    $article = ArticleService::findOne($id);

    // If not the same user, redirect this
    if ($article["user_id"] != $_SESSION["user"]["id"]) {
      \header("location: /articles");
    }

    // Create form
    $form = ArticleService::createForm($article);

    // If form is submitted
    if (isset($_POST["submit"])) {
      // If form validation is ok
      if (FormBuilder::validate($_POST, ["title", "content"])) {
        // Edit article
        ArticleService::editArticle($_POST["title"], $_POST["content"], $id);
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
    Auth::checkUserLogOut();
    ArticleService::deleteArticle($id);
  }
}
