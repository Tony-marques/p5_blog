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
use App\services\UserService;
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
            "allArticles" => $articlesPerPage,
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
//        Utilservice::beautifulArray($article);


        if (!$article) {
            \header("location: /articles");
            return;
        }
        $userRepository = new User();
        $user = $userRepository->findOne($article->getUserId());

        $userModel = new UserModel();
        $userModel->hydrate($user);

        $article->setUser($userModel);

        $commentService = new CommentService();
//        $commentService->findBy(["article_id" => $id, "published" => true]);
        $validateComments = $commentService->findBy(["articleId" => $article->getId(), "published" => true]);
        $allComments = $commentService->findBy(["articleId" => $article->getId()]);


        foreach ($validateComments as $comment) {
            $commentModel = new CommentModel();
            $commentModel->hydrate($comment);

            $userRepository = new User();
            $user = $userRepository->findOne($commentModel->getUserId());

            $commentModel->setUser($user);


//            $user = $userService->findOne($commentModel->getUser()->getId());
            $userModel = new UserModel();
            $userModel->hydrate($user);

            $commentModel->setUser($userModel);
//            Utilservice::beautifulArray($commentModel);

            $article->setComment($commentModel);
        }

        $commentsModel = [];
        foreach ($allComments as $comment) {
            $commentModel = new CommentModel();
            $commentModel->hydrate($comment);

            $userRepository = new User();
            $user = $userRepository->findOne($commentModel->getUserId());

            $commentModel->setUser($user);


//            $user = $userService->findOne($commentModel->getUser()->getId());
            $userModel = new UserModel();
            $userModel->hydrate($user);

            $commentModel->setUser($userModel);
//            Utilservice::beautifulArray($commentModel);

            $article->setComment($commentModel);

            $commentsModel[] = $commentModel;
        }
//Utilservice::beautifulArray($commentsModel);


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

                $commentRepository = new Comment();
                $commentRepository->createComment($_POST, $id, $isAdmin);
            }
        }
//
//        // Sort all comments by asc created at
//        $allComments = CommentService::sortCommentAsc($allComments);
//        // Sort validate comments by asc created at
//        $validateComments = CommentService::sortCommentAsc($validateComments);

        return $this->render("articles/show_one", "article $id", [
            "article" => $article,
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

            $articleRepository = new Article();
            if(!ArticleService::checkCreateArticle($title,$content)){
                header("location: /article/nouveau");
                return;
            }
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
//    AuthService::checkUserLogOut();

        // Find one article with $id params
        $articleRepository = new Article();
        $article = $articleRepository->findOne($id);
//UtilService::beautifulArray($article->getTitle());


        // If not the same user, redirect this
        if ($article->getUserId() != $_SESSION["user"]["id"]) {
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
            if(!$articleService->checkEditArticle($_POST["title"], $_POST["content"], $article->getId())){
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
//    AuthService::checkUserLogOut();
        $articleRepository = new Article();
        $articleRepository->deleteArticle($id);
    }
}
