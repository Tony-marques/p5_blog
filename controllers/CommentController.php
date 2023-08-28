<?php

namespace App\controllers;

use App\models\ArticleModel;
use App\models\CommentModel;
use App\services\ArticleService;
use App\services\AuthService;
use App\services\CommentService;
use App\services\UtilService;

class CommentController extends AbstractController
{
  // check if the comment is validate in DB
  public function validate($id)
  {
    AuthService::checkAdmin(pathToRedirect: "/articles");

    $commentModel = new CommentModel();
    $comment = $commentModel->findOne($id);
    $commentModel->setPublished(1);
    $commentModel->update($id);

    \header("location: /article/{$comment['article_id']}");
  }

  public function delete($id)
  {
    AuthService::checkAdmin(pathToRedirect: "/articles");

    $commentModel = new CommentModel();
    $comment = $commentModel->findOne($id);
    $commentModel->delete($id);

    \header("location: /article/{$comment['article_id']}");
  }

  public function checkAllComments()
  {
    AuthService::checkAdmin("/articles");
    // $articleModel = new ArticleModel();
    // $articlesWithNoValidateComments = $articleModel->findByJoin([
    //   "published" => false
    // ], "comments", "article_id");

    $commentModel = new CommentModel();
    $allComments = $commentModel->findAll();
    foreach ($allComments as &$comment) {
      $comment["article"] = ArticleService::findOne($comment["article_id"]);
    };
    // foreach($allComments as &$comment){
    //   UtilService::beautifulArray($comment);
    // };

    // $articleModel = new ArticleModel();
    // $articles = $articleModel->findAll();
    // UtilService::beautifulArray($articles);
    // foreach($articles as &$article){
    //   $article["comments"] = CommentService::;
    // };


    // exit;

    return $this->render("comments/all", [
      "comments" => $allComments
    ]);
  }
}
