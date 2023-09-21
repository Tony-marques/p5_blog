<?php

namespace App\services;

use App\app\Db;
use App\app\FormBuilder;
use App\models\ArticleModel;
use App\services\UtilService;

class ArticleService extends AbstractService
{
    private Db $db;

    public function __construct()
    {
        $this->db = Db::getInstance();
    }

    public function createArticle(ArticleModel $article)
    {
        $this->checkCreateArticle($article->getTitle(), $article->getContent());

        $sql = "INSERT INTO articles(`title`, `content`, `author`, `userId`) VALUES(?, ?, ?, ?)";
        $statement = $this->db->prepare($sql);
        $statement->execute([$article->getTitle(), $article->getContent(), $article->getAuthor(), $article->getUserId()]);
        return $statement;
    }

    public function checkCreateArticle(string $title, string $content)
    {

        // Form validation
        if (\strlen($title) < 5 || \strlen($content) < 20) {
            $_SESSION["error"] = [
                "article" => [
                    "title" => \strlen($title) < 5 ? "Votre titre doit faire au minimum 5 caractères" : "",
                    "content" => \strlen($content) < 20 ? "Votre contenu doit faire au minimum 20 caractères" : "",
                ]
            ];

            $_SESSION["tmp_article"] = [
                "title" => $title,
                "content" => $content
            ];

            return;
        }


        \header("location: /articles");
        return;
    }

    public function showOne(int $id){
        $sql = "SELECT * FROM articles WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);

        return $stmt->fetch();
    }



    public static function createForm(mixed $subject = null)
    {
        $CSRFToken = bin2hex(random_bytes(32));
        $_SESSION["csrf_token"] = $CSRFToken;

        $form = new FormBuilder();
        $form->startForm()
            ->startDiv(content: !empty($subject) ? "Modifier l'article {$subject['title']}" : "Créer un article")
            ->endDiv()
            ->startDiv([
                "class" => "form-container"
            ])
            ->startDiv([
                "class" => "form-group"
            ])
            ->setLabel(!empty($subject) ? "title" : "", !empty($subject) ? "Titre" : "")
            ->setInput("text", "title", [
                "value" => (!empty($_SESSION["tmp_article"]["title"])) ?
                    ($_SESSION["tmp_article"]["title"])
                    : (!empty($subject["title"]) ? $subject["title"] : ""),
                "placeholder" => !empty($subject) ? "" : "Titre"
            ])
            ->startDiv(attributs: [
                "class" => !empty($_SESSION["error"]["article"]["title"]) ? "error mt-10" : ""
            ], content: !empty($_SESSION["error"]["article"]["title"]) ? $_SESSION["error"]["article"]["title"] : "")
            ->endDiv()
            ->endDiv()
            ->startDiv([
                "class" => "form-group"
            ])
            ->setLabel(!empty($subject) ? "content" : "", !empty($subject) ? "Contenu" : "")
            ->setTextarea(
                "content",
                (!empty($_SESSION["tmp_article"]["content"])) ?
                    ($_SESSION["tmp_article"]["content"])
                    : (!empty($subject["content"]) ? $subject["content"] : ""),
                [
                    "rows" => 15,
                    "placeholder" => !empty($subject) ? "" : "Contenu"
                ]
            )
            ->startDiv(attributs: [
                "class" => !empty($_SESSION["error"]["article"]["content"]) ? "error mt-10" : ""
            ], content: !empty($_SESSION["error"]["article"]["content"]) ? $_SESSION["error"]["article"]["content"] : "")
            ->endDiv()
            ->startDiv(attributs: [
                "class" => !empty($_SESSION["error"]["csrf_token"]) ? "error mt-10" : ""
            ], content: !empty($_SESSION["error"]["csrf_token"]) ? $_SESSION["error"]["csrf_token"] : "")
            ->endDiv()
            ->endDiv()
            ->endDiv()
            ->setInput("hidden", "csrf_token", [
                "value" => $_SESSION["csrf_token"]
            ])
            ->setButton($subject ? "Modifier" : "Créer", [
                "class" => "button button-primary"
            ])
            ->endForm();

        return $form;
    }


    public function findAllArticles($limit = null, $offset = 0)
    {
        if ($limit !== null) {
            $articles = $this->findAll($limit, $offset);
        } else {
            $articles = $this->findAll();
        }

        return $articles;
    }

    public function findAll($limit = null, $offset = 0, $orderBy = "DESC")
    {
        if ($limit !== null && $offset !== null) {
            $sql = "SELECT * FROM articles LIMIT $limit OFFSET $offset ORDER BY createdAt $orderBy";
        } else {

            $sql = "SELECT * FROM articles ORDER BY createdAt $orderBy";
//            Utilservice::beautifulArray($sql);
        }
        $stmt = $this->request($sql);
        return $stmt->fetchAll();
    }

    public static function sortArticlesAsc(array $articles)
    {
        // sort article by created_at (asc)
        usort($articles, function ($a, $b) {
            return strtotime($b['created_at']) - strtotime($a['created_at']);
        });
        return $articles;
    }

    public static function editArticle(string $title, string $content, int $id)
    {
        $title = \htmlspecialchars($title);
        $content = \htmlspecialchars($content);

        // Form validation
        if (\strlen($title) < 5 || \strlen($content) < 20) {
            $_SESSION["error"] = [
                "article" => [
                    "title" => \strlen($title) < 5 ? "Votre titre doit faire au minimum 5 caractères" : "",
                    "content" => \strlen($content) < 20 ? "Votre contenu doit faire au minimum 20 caractères" : "",
                ]
            ];

            $_SESSION["tmp_article"] = [
                "title" => $title,
                "content" => $content
            ];

            \header("location: /article/edition/$id");
            return;
        }

        $article = new ArticleModel();
        $article->setTitle($title)
            ->setContent($content);

        $article->update($id);
        \header("location: /articles");
        return;
    }

    public static function deleteArticle(int $id)
    {
        $articleModel = new ArticleModel();
        // Find one article
        $article = self::findOne($id);

        // If not the same user, redirect
        if ($article["user_id"] != $_SESSION["user"]["id"]) {
            \header("location: /article/$id");
            return;
        }

        // Delete article
        $articleModel->delete($id);

        // Redirect after deleted article
        \header("location: /articles");
        return;
    }

}
