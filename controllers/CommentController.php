<?php

namespace App\controllers;

use App\models\CommentModel;
use App\Repositories\Comment;
use App\services\ArticleService;
use App\services\UserService;

class CommentController extends AbstractController
{
    /**
     * Validate the comment from article page
     */
    public function validate($id) // OK
    {
//    AuthService::checkAdmin(pathToRedirect: "/articles");

        $commentRepository = new Comment();
        $comment = $commentRepository->findOne($id);
        $comment->setPublished(true);
        $commentRepository->save($comment);

        \header("location: /article/{$comment->getArticleId()}");
        return;
    }

    /**
     * Validate the comment from comments page
     */
    public function validateFromComments($id) // OK
    {
//    AuthService::checkAdmin(pathToRedirect: "/articles");

        $commentRepository = new Comment();
        $comment = $commentRepository->findOne($id);
        $comment->setPublished(true);
        $commentRepository->save($comment);

        \header("location: /commentaires");
        return;
    }

    /**
     * Delete comment from the article page
     */
    public function delete($id) // OK
    {
//    AuthService::checkAdmin(pathToRedirect: "/articles");
        $commentRepository = new Comment();
        $comment = $commentRepository->findOne($id);
        $commentRepository->deleteComment($id);

        \header("location: /article/{$comment->getArticleId()}");
        return;
    }

    /**
     * Delete comment from comments page
     */
    public function deleteFromComments($id) // OK
    {
//    AuthService::checkAdmin(pathToRedirect: "/articles");
        $commentRepository = new Comment();
        $commentRepository->deleteComment($id);

        \header("location: /commentaires");
        return;
    }

    /**
     * Display comments
     */
    public function checkAllComments()
    {
//    AuthService::checkAdmin("/articles");

        $commentModel = new CommentModel();

        $allComments = $commentModel->findBy(["published" => 0]);
        foreach ($allComments as &$comment) {
            $comment["article"] = ArticleService::findOne($comment["article_id"]);
            $comment["user_comment"] = UserService::findOne($comment["user_id"]);
            $comment["user_article"] = UserService::findOne($comment["article"]["user_id"]);
        };

        return $this->render("comments/all", "commentaires", [
            "comments" => $allComments
        ]);
    }
}
