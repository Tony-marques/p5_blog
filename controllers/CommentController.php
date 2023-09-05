<?php

namespace App\controllers;

use App\models\CommentModel;
use App\services\ArticleService;
use App\services\AuthService;
use App\services\UserService;

class CommentController extends AbstractController
{
  /**
   * Validate the comment from article page
   */
  public function validate($id)
  {
    AuthService::checkAdmin(pathToRedirect: "/articles");

    $commentModel = new CommentModel();
    $comment = $commentModel->findOne($id);
    $commentModel->setPublished(1);
    $commentModel->update($id);

    \header("location: /article/{$comment['article_id']}");
    exit;
  }

  /**
   * Validate the comment from comments page
   */
  public function validateFromComments($id)
  {
    AuthService::checkAdmin(pathToRedirect: "/articles");

    $commentModel = new CommentModel();
    $comment = $commentModel->findOne($id);
    $commentModel->setPublished(1);
    $commentModel->update($id);

    \header("location: /commentaires");
    exit;
  }

  /**
   * Delete comment from the article page
   */
  public function delete($id)
  {
    AuthService::checkAdmin(pathToRedirect: "/articles");

    $commentModel = new CommentModel();
    $comment = $commentModel->findOne($id);
    $commentModel->delete($id);

    \header("location: /article/{$comment['article_id']}");
    exit;
  }
  
  /**
   * Delete comment from comments page
   */
  public function deleteFromComments($id)
  {
    AuthService::checkAdmin(pathToRedirect: "/articles");

    $commentModel = new CommentModel();
    $comment = $commentModel->findOne($id);
    $commentModel->delete($id);

    \header("location: /commentaires");
    exit;
  }

  /**
   * Display comments
   */
  public function checkAllComments()
  {
    AuthService::checkAdmin("/articles");

    $commentModel = new CommentModel();

    $allComments = $commentModel->findBy(["published" => 0]);
    foreach ($allComments as &$comment) {
      $comment["article"] = ArticleService::findOne($comment["article_id"]);
      $comment["user_comment"] = UserService::findOne($comment["user_id"]);
      $comment["user_article"] = UserService::findOne($comment["article"]["user_id"]);
    };

    return $this->render("comments/all","commentaires",[
      "comments" => $allComments
    ]);
  }
}
