<?php

namespace App\controllers;

use App\models\ArticleModel;
use App\models\CommentModel;
use App\services\UtilService;

class CommentController extends AbstractController
{

  public function validate($id)
  {
    $commentModel = new CommentModel();
    $comment = $commentModel->findOne($id);
    $commentModel->setPublished(1);
    $commentModel->update($id);

    \header("location: /article/{$comment['article_id']}");
  }

  public function delete($id)
  {
    $commentModel = new CommentModel();
    $comment = $commentModel->findOne($id);
    $commentModel->delete($id);

    \header("location: /article/{$comment['article_id']}");
  }

  public function checkAllComments()
  {
    $articleModel = new ArticleModel();
    $articlesWithNoValidateComments = $articleModel->findByJoin([
      "published" => false
    ], "comments", "article_id");
    UtilService::beautifulArray($articlesWithNoValidateComments[0]);
    $commentModel = new CommentModel();
    // $comments = $commentModel->findBy(["published" => false]);

    return $this->render("comments/all", [
      // "comments" => $comments
      "articlesWithNoValidateComments" => $articlesWithNoValidateComments
    ]);
  }
}
