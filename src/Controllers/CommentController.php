<?php

namespace App\Controllers;

use App\Controllers\AbstractController;
use App\Repositories\ArticleRepository;
use App\Repositories\CommentRepository;
use App\Repositories\UserRepository;
use App\Services\AuthService;

class CommentController extends AbstractController
{
    /**
     * Validate the comment from article page
     */
    public function validate($id) // OK
    {
    AuthService::checkAdmin(pathToRedirect: "/articles");

        $commentRepository = new CommentRepository();
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

        $commentRepository = new CommentRepository();
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
        $commentRepository = new CommentRepository();
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
        $commentRepository = new CommentRepository();
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

        $commentRepository = new CommentRepository();
        $allComments = $commentRepository->findBy(["published" => 0]);

        $result = [];
        foreach ($allComments as $comment) {
            $userRepository = new UserRepository();
            $user = $userRepository->findOne($comment->getUserId());

            $articleRepository = new ArticleRepository();
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
