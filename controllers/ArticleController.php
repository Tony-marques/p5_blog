<?php

namespace App\controllers;

use App\app\Db;
use App\app\exceptions\ArticleException;
use App\app\FormBuilder;

//use App\services\AuthService;
use App\models\ArticleModel;
use App\models\CommentModel;
use App\models\UserModel;
use App\services\ArticleService;
use App\services\AuthService;
use App\services\CommentService;
use App\services\Pagination;
use App\services\UserService;
use App\services\UtilService;

class ArticleController extends AbstractController
{
    /**
     * all articles show
     */
    public function index($page = null)
    {
        $articleService = new ArticleService();
        [$articlesPerPage, $allArticles, $currentPage, $totalPages] = Pagination::paginate(page: $page, service: $articleService->findAllArticles(), redirect: "/articles", limit: 3);
//      Utilservice::beautifulArray($allArticles);
        $userService = new UserService();

        $articles = [];
        foreach ($allArticles as $article) {
            $articleModel = new ArticleModel();
            $articleModel->hydrate($article);

            $user = $userService->findOne($articleModel->getUserId());
            $userModel = new UserModel();
            $userModel->hydrate($user);
            $articleModel->setUser($userModel);
            $articles[] = $articleModel;
        }

        $articlesPage = [];
//        foreach ($articlesPerPage as $article) {
//            $articleModel = new ArticleModel();
//            $articleModel->hydrate($article);
//            $articlesPage[] = $articleModel;
//        }
        foreach ($articlesPerPage as $article) {
            $articleModel = new ArticleModel();
            $articleModel->hydrate($article);

            $user = $userService->findOne($articleModel->getUserId());
            $articleModel->setUser($user);
            $articlesPage[] = $articleModel;
        }
//        Utilservice::beautifulArray($articles);

//        $articlesSorted = ArticleService::sortArticlesAsc($articlesPerPage);

        return $this->render("articles/index", "articles", [
//            "articles" => $articlesSorted,
            "allArticles" => $articles,
//            "currentPage" => $currentPage,
            "totalPages" => $totalPages
        ]);
    }

    /**
     * one article
     */
    public function showOne(string $id)
    {
        $id = (int)$id;

        $articleService = new ArticleService();
        $article = $articleService->showOne($id);
//        Utilservice::beautifulArray($article);
        $articleModel = new ArticleModel();
        $articleModel->hydrate($article);


        if (!$article) {
            \header("location: /articles");
            return;
        }
        $userService = new UserService();
        $user = $userService->findOne($articleModel->getUserId());

        $userModel = new UserModel();
        $userModel->hydrate($user);

        $articleModel->setUser($userModel);

        $commentService = new CommentService();
//        $commentService->findBy(["article_id" => $id, "published" => true]);
        $validateComments = $commentService->findBy(["articleId" => $articleModel->getId(), "published" => true]);
        $allComments = $commentService->findBy(["articleId" => $articleModel->getId()]);


        foreach ($validateComments as $comment) {
            $commentModel = new CommentModel();
            $commentModel->hydrate($comment);

            $user = $userService->findOne($commentModel->getUserId());
            $userModel = new UserModel();
            $userModel->hydrate($user);

            $commentModel->setUser($userModel);
//            Utilservice::beautifulArray($commentModel);

            $articleModel->setComment($commentModel);
        }

        $commentsModel = [];
        foreach ($allComments as $comment) {
            $commentModel2 = new CommentModel();

            $commentModel2->hydrate($comment);

            $user = $userService->findOne($commentModel2->getUserId());
            $userModel = new UserModel();
            $userModel->hydrate($user);

            $commentModel2->setUser($userModel);

            $commentsModel[] = $commentModel2;
        }
//        print_r($commentsModel);


//        $validateComments = CommentService::findBy(["article_id" => $id, "published" => true], "articles", "article_id", "id");
//        $allComments = CommentService::findBy(["article_id" => $id]);
//
//        foreach ($allComments as &$comment) {
//            $user = UserService::findOne($comment["user_id"]);
//            $article_ = ArticleService::findOne($comment["article_id"]);
//            $comment["user"] = $user;
//            $comment["article"] = $article_;
//        }
//        foreach ($validateComments as &$comment) {
//            $user = UserService::findOne($comment["user_id"]);
//            $article_ = ArticleService::findOne($comment["article_id"]);
//            $comment["user"] = $user;
//            $comment["article"] = $article_;
//        }
//
        // Check if user is login
        if (isset($_SESSION["user"])) {
            $isAdmin = AuthService::isAdmin();
        } else {
            $isAdmin = false;
            $currentUser = null;
        }
//
//        // Create form for comments
        $commentForm = CommentService::createForm();
//
        // If form is submited
        if (isset($_POST["submit"])) {
            // If form validation is ok
            if (FormBuilder::validate($_POST, ["comment"])) {
                // Create comment
                CommentService::createComment($id, $_POST["comment"]);
            }
        }
//
//        // Sort all comments by asc created at
//        $allComments = CommentService::sortCommentAsc($allComments);
//        // Sort validate comments by asc created at
//        $validateComments = CommentService::sortCommentAsc($validateComments);

        return $this->render("articles/show_one", "article $id", [
            "article" => $articleModel,
            "commentForm" => $commentForm->create(),
//            "validateComments" => $validateComments,
            "allComments" => $commentsModel,
////      "isAdmin" => $isAdmin,
        ]);
    }

    /**
     * Create new article
     */
    public function new()
    {
//    AuthService::checkUserLogOut();
//    AuthService::checkAdmin(pathToRedirect: "/articles");

        if (isset($_POST["submit"])) {
            if ($_SESSION["csrf_token"] !== $_POST["csrf_token"]) {
                $_SESSION["error"]["csrf_token"] = "Il y a un problème avec votre token";

                \header("location: /article/nouveau");
                return;
            }

            $content = htmlspecialchars($_POST["content"]);
            $title = htmlspecialchars($_POST["title"]);

            $articleModel = new ArticleModel();
            $articleModel->setContent($content)
                ->setTitle($title)
                ->setAuthor("")
                ->setUserId($_SESSION["user"]["id"]);

            $articleService = new ArticleService();
            $articleService->createArticle($articleModel);
        }

        $form = ArticleService::createForm();

        return $this->render("articles/new", "création article", ["form" => $form->create()]);
    }

    /**
     * Edit this article
     */
    public function edit($id)
    {
//    AuthService::checkUserLogOut();

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
//    AuthService::checkUserLogOut();
        ArticleService::deleteArticle($id);
    }
}
