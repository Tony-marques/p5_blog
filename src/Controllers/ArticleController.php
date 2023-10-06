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
use App\Services\UtilService;

class ArticleController extends AbstractController
{
    /**
     * Show all articles
     * @param string|null $page
     * @return void
     */
    public function index(?string $page = null): void
    {
        $articleRepository = new ArticleRepository();
        $articles = $articleRepository->findAll();

        [$articlesPerPage, $currentPage, $totalPages] = Pagination::paginate(page: $page, service: $articles, redirect: "/articles", limit: 5);

        $this->render("articles/index", "articles", [
            "articlesPerPage" => $articlesPerPage,
            "allArticles" => $articles,
            "totalPages" => $totalPages
        ]);
    }


    /**
     * Show one article
     * @param string $id
     * @return void
     */
    public function showOne(string $id): void
    {
        $id = (int)$id;

        $articleRepository = new ArticleRepository();
        $article = $articleRepository->findOne($id);
//        UtilService::beautifulArray($article->getComment());

        if (!$article->getId()) {
            header("Location: /articles");
            return;
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

        $countValidateComments = 0;
        foreach ($article->getComment() as $comment) {
            if ($comment->getPublished() == true) {
                $countValidateComments++;
            }
        }

        $this->render("articles/show_one", "article $id", [
            "article" => $article,
            "commentForm" => $commentForm->create(),
            "countValidateComments" => $countValidateComments
        ]);
    }


    /**
     * Create new article
     * @return void
     */
    public function new(): void
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

        $this->render("articles/new", "création article", ["form" => $form->create()]);
    }


    /**
     * Edit one article
     * @param string $id
     * @return void
     */
    public function edit(string $id): void
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

        $this->render("articles/edition", "édition article $id", [
            "article" => $article,
            "form" => $form->create()
        ]);
    }


    /**
     * Delete one article
     * @param string $id
     * @return void
     */
    public function delete(string $id): void
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
