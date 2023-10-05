<?php

namespace App\Repositories;

use App\App\Db;
use App\Models\Article;
use App\Services\UtilService;

class ArticleRepository
{
    private Db $db;

    public function __construct()
    {
        $this->db = Db::getInstance();
    }

    private function hydrate($article, $data): Article
    {
        foreach ($data as $cle => $valeur) {
            $methode = 'set' . ucfirst($cle);
            if (method_exists($article, $methode)) {
                $article->$methode($valeur);
            }
        }
        return $article;
    }

    public function findOne(int $id = null): Article
    {
        $sql = "SELECT * FROM articles WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);

        $articleModel = new Article();
        $this->hydrate($articleModel, (array)$stmt->fetch());
        return $articleModel;
    }

    public function findAll(): array
    {
        $sql = "SELECT * FROM articles ORDER BY createdAt DESC";
        $stmt = $this->db->query($sql);
        $articles = $stmt->fetchAll();

        $articlesObj = [];
        foreach ($articles as $article) {
            $articleModel = new Article();
            $this->hydrate($articleModel, $article);
            $articlesObj[] = $articleModel;
        }
        return $articlesObj;
    }

    public function create($post): void
    {
        $title = htmlspecialchars($post["title"]);
        $content = htmlspecialchars($post["content"]);
        $chapo = htmlspecialchars($post["chapo"]);

//        UtilService::beautifulArray($post);

        $sql = "INSERT INTO articles(`title`, `content`, `chapo`, `userId`) VALUES(?, ?, ?, ?)";
        $statement = $this->db->prepare($sql);
        $statement->execute([$title, $content, $chapo, $_SESSION["user"]["id"]]);
    }

    public function update($post, $article): void
    {
        $content = htmlspecialchars($post["content"]);
        $title = htmlspecialchars($post["title"]);
        $chapo = htmlspecialchars($post["chapo"]);

        $sql = "UPDATE articles SET content = ?, title = ?, chapo = ? WHERE id = ?";
        $statement = $this->db->prepare($sql);
        $statement->execute([$content, $title, $chapo, $article->getId()]);

        header("location: /article/{$article->getId()}");
        return;
    }

    public function deleteArticle($id): void
    {
        $sql = "DELETE FROM articles WHERE id = ?";

        $statement = $this->db->prepare($sql);
        $statement->execute([$id]);

        \header("location: /articles");
        return;
    }
}