<?php

namespace App\controllers;

use App\app\exceptions\ArticleException;
use App\app\FormBuilder;
use App\services\AuthService;
use App\services\ArticleService;
use App\services\CommentService;
use App\services\Pagination;
use App\services\UserService;

class ArticleController extends AbstractController
{
  /**
   * all articles show
   */
  public function index($page = null)
  {
    [$articlesPerPage, $allArticles, $currentPage, $totalPages] = Pagination::paginate(page: $page, service: ArticleService::findAllArticles(), redirect: "/articles", limit: 3);

    foreach ($articlesPerPage as &$article) {
      $user = UserService::findOne($article["user_id"]);
      $article["user"] = $user;
    }

    $articlesSorted = ArticleService::sortArticlesAsc($articlesPerPage);

    return $this->render("articles/index", "articles", [
      "articles" => $articlesSorted,
      "allArticles" => $allArticles,
      "currentPage" => $currentPage,
      "totalPages" => $totalPages
    ]);
  }

  /**
   * one article
   */
  public function showOne(string $id)
  {
    $id = (int)$id;

    $article = ArticleService::findOne($id);
    if (!$article) {
      \header("location: /articles");
      throw new ArticleException();
    }

    $article["user"] = UserService::findOne((int)$article["user_id"]);

    $validateComments = CommentService::findBy(["article_id" => $id, "published" => true], "articles", "article_id", "id");
    $allComments = CommentService::findBy(["article_id" => $id]);

    foreach ($allComments as &$comment) {
      $user = UserService::findOne($comment["user_id"]);
      $article_ = ArticleService::findOne($comment["article_id"]);
      $comment["user"] = $user;
      $comment["article"] = $article_;
    }
    foreach ($validateComments as &$comment) {
      $user = UserService::findOne($comment["user_id"]);
      $article_ = ArticleService::findOne($comment["article_id"]);
      $comment["user"] = $user;
      $comment["article"] = $article_;
    }

    // Check if user is login
    if (isset($_SESSION["user"])) {
      $currentUser = UserService::findOne($_SESSION["user"]["id"]);
      $isAdmin = AuthService::isAdmin();
    } else {
      $isAdmin = false;
      $currentUser = null;
    }

    // Create form for comments
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

    return $this->render("articles/show_one", "article $id", [
      "article" => $article,
      "commentForm" => $commentForm->create(),
      "validateComments" => $validateComments,
      "allComments" => $allComments,
      "isAdmin" => $isAdmin,
      "currentUser" => $currentUser,
    ]);
  }

  /**
   * Create new article
   */
  public function new()
  {
    AuthService::checkUserLogOut();
    AuthService::checkAdmin(pathToRedirect: "/articles");

    if (isset($_POST["submit"])) {
      if ($_SESSION["csrf_token"] !== $_POST["csrf_token"]) {
        $_SESSION["error"]["csrf_token"] = "Il y a un problème avec votre token";

        \header("location: /article/nouveau");
        return;
      }
      ArticleService::createArticle($_POST["title"], $_POST["content"]);
    }

    $form = ArticleService::createForm();

    return $this->render("articles/new", "création article", ["form" => $form->create()]);
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
      return;
    }

    // If form is submitted
    if (isset($_POST["submit"])) {
      // Edit article
      if ($_SESSION["csrf_token"] !== $_POST["csrf_token"]) {
        $_SESSION["error"]["csrf_token"] = "Il y a un problème avec votre token";

        \header("location: /article/edition/$id");
        return;
      }
      ArticleService::editArticle($_POST["title"], $_POST["content"], $id);
    }

    // Create form
    $form = ArticleService::createForm($article);

    return $this->render("articles/edition", "édition article $id", [
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
