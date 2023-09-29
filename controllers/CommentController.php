<?php

namespace App\controllers;

use App\models\CommentModel;
use App\models\UserModel;
use App\Repositories\Article;
use App\Repositories\Comment;
use App\Repositories\User;
use App\services\ArticleService;
use App\services\AuthService;
use App\services\UserService;
use App\services\UtilService;

class CommentController extends AbstractController
{
    /**
     * Validate the comment from article page
     */
    public function validate($id) // OK
    {
    AuthService::checkAdmin(pathToRedirect: "/articles");

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
    AuthService::checkAdmin(pathToRedirect: "/articles");

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
    AuthService::checkAdmin(pathToRedirect: "/articles");
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
    AuthService::checkAdmin(pathToRedirect: "/articles");
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
    AuthService::checkAdmin("/articles");

        $commentRepository = new Comment();
        $allComments = $commentRepository->findBy(["published" => 0]);

        $result = [];
        foreach ($allComments as $comment) {
            $userRepository = new User();
            $user = $userRepository->findOne($comment->getUserId());

            $articleRepository = new Article();
            $article = $articleRepository->findOne($comment->getArticleId());

            $comment->setUser($user);
            $comment->setArticle($article);

            $result[] = $comment;
        }


        return $this->render("comments/all", "commentaires", [
            "comments" => $result
        ]);
    }
}
