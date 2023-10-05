<?php

namespace App\Controllers;

use App\App\FormBuilder;
use App\Repositories\ArticleRepository;
use App\Repositories\CommentRepository;
use App\Repositories\UserRepository;
use App\Services\ArticleService;
use App\Services\AuthService;
use App\Services\CommentService;
use App\Services\Pagination;

class ArticleController extends AbstractController
{

    /**
     * Show all articles
     * @param $page
     * @return null
     */
    public function index($page = null)
    {
        $articleRepository = new ArticleRepository();
        $articlesObj = $articleRepository->findAll();

        [$articlesPerPage, $currentPage, $totalPages] = Pagination::paginate(page: $page, service: $articleRepository->findAll(), redirect: "/articles", limit: 5);
        $userRepository = new UserRepository();

        foreach ($articlesObj as $article) {
            $user = $userRepository->findOne($article->getUserId());
            $article->setUser($user);
        }

        foreach ($articlesPerPage as $article) {
            $user = $userRepository->findOne($article->getUserId());
            $article->setUser($user);
        }


        return $this->render("articles/index", "articles", [
            "articlesPerPage" => $articlesPerPage,
            "allArticles" => $articlesObj,
            "totalPages" => $totalPages
        ]);
    }


    /**
     * Show one article
     * @param string $id
     * @return void|null
     */
    public function showOne(string $id)
    {
        $id = (int)$id;

        $articleRepository = new ArticleRepository();
        $article = $articleRepository->findOne($id);

        if (!$article->getId()) {
            header("Location: /articles");
            return;
        }


        $userRepository = new UserRepository();
        $user = $userRepository->findOne($article->getUserId());
        $article->setUser($user);

        $commentRepository = new CommentRepository();

        $allComments = $commentRepository->findBy(["articleId" => $article->getId()]);
        $validateComments = $commentRepository->findBy(["articleId" => $article->getId(), "published" => true]);

        $commentsResults = [];
        foreach ($allComments as $comment) {

            $userRepository = new UserRepository();
            $user = $userRepository->findOne($comment->getUserId());

            $comment->setUser($user);

            $commentsResults[] = $comment;
        }

        $commentsValidateResults = [];
        foreach ($validateComments as $comment) {

            $userRepository = new UserRepository();
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

        // Create form for comments
        $commentForm = CommentService::createForm();

        // If form is submited
        if (isset($_POST["submit"])) {
            // If form validation is ok
            if (FormBuilder::validate($_POST, ["comment"])) {
                echo "test";
                AuthService::checkUserLogged();
                $commentRepository = new CommentRepository();
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
     * @return void|null
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
            $chapo = htmlspecialchars($_POST["chapo"]);

            if (!ArticleService::checkCreateArticle($title, $content, $chapo)) {
                header("location: /article/nouveau");
                return;
            }
            $articleRepository = new ArticleRepository();
            $articleRepository->create($_POST);

        }

        $form = ArticleService::createForm();

        return $this->render("articles/new", "création article", ["form" => $form->create()]);
    }


    /**
     * Edit one article
     * @param $id
     * @return void|null
     */
    public function edit($id)
    {
        // Find one article with $id params
        $articleRepository = new ArticleRepository();
        $article = $articleRepository->findOne($id);

        //        If article not exist
        if (!$article->getId()) {
            \header("location: /articles");
            return;
        }

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
            $articleRepository = new ArticleRepository();
            $article = $articleRepository->findOne($id);

            $articleService = new ArticleService();
            if (!$articleService->checkEditArticle($_POST["title"], $_POST["content"], $_POST["chapo"], $article->getId())) {
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
     * Delete one article
     * @param $id
     * @return void
     */
    public function delete($id)
    {
        // Find one article with $id params
        $articleRepository = new ArticleRepository();
        $article = $articleRepository->findOne($id);

//        If article not exist
        if (!$article->getId()) {
            \header("location: /articles");
            return;
        }

//         If not the same user, redirect this
        if ($article->getUserId() != $_SESSION["user"]["id"] && !AuthService::isAdmin()) {
            \header("location: /articles");
            return;
        }

        $articleRepository = new ArticleRepository();
        $articleRepository->deleteArticle($id);
    }
}
