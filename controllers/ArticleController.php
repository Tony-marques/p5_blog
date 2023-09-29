<?php

namespace App\controllers;

use App\app\Db;
use App\app\exceptions\ArticleException;
use App\app\FormBuilder;

//use App\services\AuthService;
use App\models\ArticleModel;
use App\models\CommentModel;
use App\models\UserModel;
use App\Repositories\Article;
use App\Repositories\Comment;
use App\Repositories\User;
use App\services\ArticleService;
use App\services\AuthService;
use App\services\CommentService;
use App\services\Pagination;
use App\services\UtilService;

class ArticleController extends AbstractController
{
    /**
     * all articles show
     */
    public function index($page = null)
    {
        $articleRepository = new Article();
        $articlesObj = $articleRepository->findAll();

        [$articlesPerPage, $currentPage, $totalPages] = Pagination::paginate(page: $page, service: $articleRepository->findAll(), redirect: "/articles", limit: 3);
        $userRepository = new User();

        $articles = [];
        foreach ($articlesObj as $article) {
            $user = $userRepository->findOne($article->getUserId());
            $article->setUser($user);
            $articles[] = $article;
        }


        $articlesPage = [];
        foreach ($articlesPerPage as $article) {
            $user = $userRepository->findOne($article->getUserId());
            $article->setUser($user);
            $articlesPage[] = $article;
        }

        return $this->render("articles/index", "articles", [
            "articlesPerPage" => $articlesPerPage,
            "allArticles" => $articlesObj,
            "totalPages" => $totalPages
        ]);
    }

    /**
     * one article
     */
    public function showOne(string $id)
    {
        $id = (int)$id;

        $articleRepository = new Article();
        $article = $articleRepository->findOne($id);


        $userRepository = new User();
        $user = $userRepository->findOne($article->getUserId());
        $article->setUser($user);

        $commentRepository = new Comment();

        $allComments = $commentRepository->findBy(["articleId" => $article->getId()]);
        $validateComments = $commentRepository->findBy(["articleId" => $article->getId(), "published" => true]);

        $commentsResults = [];
        foreach ($allComments as $comment) {

            $userRepository = new User();
            $user = $userRepository->findOne($comment->getUserId());

            $comment->setUser($user);

            $commentsResults[] = $comment;
        }

        $commentsValidateResults = [];
        foreach ($validateComments as $comment) {

            $userRepository = new User();
            $user = $userRepository->findOne($comment->getUserId());

            $comment->setUser($user);

            $commentsValidateResults[] = $comment;
        }


        // Check if user is login
        if (isset($_SESSION["user"])) {
            $isAdmin = AuthService::isAdmin();
        } else {
            $isAdmin = false;
            $currentUser = null;
        }

//        // Create form for comments
        $commentForm = CommentService::createForm();
//
        // If form is submited
        if (isset($_POST["submit"])) {
            // If form validation is ok
            if (FormBuilder::validate($_POST, ["comment"])) {
            echo "test";
            AuthService::checkUserLogged();
                $commentRepository = new Comment();
                $commentRepository->createComment($_POST, $id, $isAdmin);
            }
        }

        return $this->render("articles/show_one", "article $id", [
            "article" => $article,
            "commentForm" => $commentForm->create(),
            "validateComments" => $commentsValidateResults,
            "allComments" => $commentsResults,
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

            $content = htmlspecialchars($_POST["content"]);
            $title = htmlspecialchars($_POST["title"]);

            if (!ArticleService::checkCreateArticle($title, $content)) {
                header("location: /article/nouveau");
                return;
            }
            $articleRepository = new Article();
            $articleRepository->create($_POST);

        }

        $form = ArticleService::createForm();

        return $this->render("articles/new", "création article", ["form" => $form->create()]);
    }

    /**
     * Edit this article
     */
    public function edit($id)
    {
    AuthService::checkAdmin();

        // Find one article with $id params
        $articleRepository = new Article();
        $article = $articleRepository->findOne($id);

        // If not the same user, redirect this
        if ($article->getUserId() != $_SESSION["user"]["id"] && !AuthService::isAdmin()) {
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
            $articleRepository = new Article();
            $article = $articleRepository->findOne($id);

            $articleService = new ArticleService();
            if (!$articleService->checkEditArticle($_POST["title"], $_POST["content"], $article->getId())) {
                header("location: /article/edition/{$article->getId()}");
                return;
            }
            $articleRepository->update($_POST, $article);
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
        AuthService::checkAdmin();

        // Find one article with $id params
        $articleRepository = new Article();
        $article = $articleRepository->findOne($id);

        // If not the same user, redirect this
        if ($article->getUserId() != $_SESSION["user"]["id"] && !AuthService::isAdmin()) {
            \header("location: /articles");
            return;
        }

        $articleRepository = new Article();
        $articleRepository->deleteArticle($id);
    }
}
