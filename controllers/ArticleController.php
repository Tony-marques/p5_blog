<?php

namespace App\controllers;

use App\app\FormBuilder;
use App\services\AuthService;
use App\services\ArticleService;
use App\services\CommentService;
use App\services\UserService;

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
      $currentUser = UserService::findOne($_SESSION["user"]["id"]);
      $isAdmin = AuthService::isAdmin();
    } else {
      $isAdmin = false;
      $currentUser = null;
    }

    // // Create form for comments
    $commentForm = CommentService::createForm();

    // If form is submited
    if (isset($_POST["submit"])) {
      // If form validation is ok
      if (FormBuilder::validate($_POST, ["comment"])) {
        // Create comment
        CommentService::createComment($id, $_POST["comment"]);
      }
    }

    // Sort all comments by asc created at
    $allComments = CommentService::sortCommentAsc($allComments);
    // Sort validate comments by asc created at
    $validateComments = CommentService::sortCommentAsc($validateComments);

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
    AuthService::checkUserLogOut();

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
    AuthService::checkUserLogOut();

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
    AuthService::checkUserLogOut();
    ArticleService::deleteArticle($id);
  }
}
