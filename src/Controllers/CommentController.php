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
     * @param string $id
     * @return void
     */
    public function validate(string $id): void
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
     * @param string $id
     * @return void
     */
    public function validateFromComments(string $id):void
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
     * @param string $id
     * @return void
     */
    public function delete(string $id):void
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
     * @param string $id
     * @return void
     */
    public function deleteFromComments(string $id):void
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
     * @return void
     */
    public function checkAllComments():void
    {
    AuthService::checkAdmin("/articles");
        $articleRepository = new ArticleRepository();
        $articles = $articleRepository->findAll();

        $this->render("comments/all", "commentaires", [
            "articles" => $articles,
        ]);
    }
}
