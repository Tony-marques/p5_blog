<?php

namespace App\Repositories;

use App\app\Db;
use App\models\ArticleModel;
use App\models\CommentModel;
use App\services\ArticleService;
use App\services\UtilService;

class Article
{
    private Db $db;

    public function __construct()
    {
        $this->db = Db::getInstance();
    }

    private function hydrate($article, $data) // OK
    {
        foreach ($data as $cle => $valeur) {
            $methode = 'set' . ucfirst($cle);
            if (method_exists($article, $methode)) {
                $article->$methode($valeur);
            }
        }
        return $article;
    }

    public function findOne(int $id) // OK
    {
        $sql = "SELECT * FROM articles WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);

        $articleModel = new ArticleModel();
        $this->hydrate($articleModel, $stmt->fetch());
        return $articleModel;
    }

    public function findAll()
    {
        $sql = "SELECT * FROM articles ORDER BY createdAt DESC";
        $stmt = $this->db->query($sql);
        $articles = $stmt->fetchAll();

        $articlesObj = [];
        foreach ($articles as $article) {
            $articleModel = new ArticleModel();
            $this->hydrate($articleModel, $article);
            $articlesObj[] = $articleModel;
        }
//UtilService::beautifulArray($articlesObj);
        return $articlesObj;
    }

    public function create($post){
        $title = htmlspecialchars($post["title"]);
        $content = htmlspecialchars($post["content"]);

        $sql = "INSERT INTO articles(`title`, `content`, `userId`) VALUES(?, ?, ?)";
        $statement = $this->db->prepare($sql);
        $statement->execute([$title, $content, $_SESSION["user"]["id"]]);

    }

    public function update($post, $article) // OK
    {
        $content = htmlspecialchars($post["content"]);
        $title = htmlspecialchars($post["title"]);

        $sql = "UPDATE articles SET content = ?, title = ? WHERE id = ?";
        $statement = $this->db->prepare($sql);
        $statement->execute([$content, $title, $article->getId()]);

        header("location: /article/{$article->getId()}");
        return;
    }

    public function deleteArticle($id) // OK
    {
        $articleRepository = new Article();
        $article = $articleRepository->findOne($id);

        if ($article->getUserId() != $_SESSION["user"]["id"]) {
            \header("location: /article/$id");
            return;
        }

        $sql = "DELETE FROM articles WHERE id = ?";

        $statement = $this->db->prepare($sql);
        $statement->execute([$id]);

        \header("location: /articles");
        return;
    }
}