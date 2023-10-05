<?php

namespace App\Controllers;

use App\Repositories\ArticleRepository;
use App\Repositories\CommentRepository;
use App\Repositories\UserRepository;
use App\Services\AuthService;
use App\Services\UtilService;

class CommentController extends AbstractController
{

    /**
     * Validate the comment from article page
     * @param $id
     * @return void
     */
    public function validate($id)
    {
    AuthService::checkAdmin(pathToRedirect: "/articles");

        $commentRepository = new CommentRepository();
        $comment = $commentRepository->findOne($id);

        if($comment->getId() === null) {
            header("location: /");
            return;
        }

        if(!AuthService::isAdmin()){
            header("location: /");
            return;
        }

        $comment->setPublished(true);
        $commentRepository->save($comment);

        \header("location: /article/{$comment->getArticleId()}");
        return;
    }


    /**
     * Validate the comment from comments page
     * @param $id
     * @return void
     */
    public function validateFromComments($id)
    {
        $commentRepository = new CommentRepository();
        $comment = $commentRepository->findOne($id);

        if($comment->getId() === null) {
            header("location: /");
            return;
        }

        if(!AuthService::isAdmin()){
            header("location: /");
            return;
        }

        $comment->setPublished(true);
        $commentRepository->save($comment);

        \header("location: /commentaires");
        return;
    }


    /**
     * Delete comment from the article page
     * @param $id
     * @return void
     */
    public function delete($id)
    {
        $commentRepository = new CommentRepository();
        $comment = $commentRepository->findOne($id);

        if($comment->getId() === null) {
            header("location: /articles");
            return;
        }

        if(!AuthService::isAdmin()){
            header("location: /articles");
            return;
        }

        $commentRepository->deleteComment($id);

        \header("location: /article/{$comment->getArticleId()}");
        return;
    }


    /**
     * Delete comment from comments page
     * @param $id
     * @return void
     */
    public function deleteFromComments($id) // OK
    {
        $commentRepository = new CommentRepository();
        $comment = $commentRepository->findOne($id);

        if($comment->getId() === null) {
            header("location: /articles");
            return;
        }

        if(!AuthService::isAdmin()){
            header("location: /articles");
            return;
        }

        $commentRepository->deleteComment($id);

        \header("location: /commentaires");
        return;
    }


    /**
     * Display comments
     * @return null
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
