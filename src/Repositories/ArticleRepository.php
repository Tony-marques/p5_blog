<?php

namespace App\Repositories;

use App\App\Db;
use App\Models\Article;

class ArticleRepository
{
    private Db $db;

    public function __construct()
    {
        $this->db = Db::getInstance();
    }

    private function hydrate($article,$data) // OK
    {
        foreach ($data as $cle => $valeur) {
            $methode = 'set' . ucfirst($cle);
            if (method_exists($article, $methode)) {
                $article->$methode($valeur);
            }
        }
        return $article;
    }

    public function findOne(int $id = null) // OK
    {
        $sql = "SELECT * FROM articles WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);

        $articleModel = new Article();
        $this->hydrate($articleModel, (array)$stmt->fetch());
        return $articleModel;
    }

    public function findAll()
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
        $articleRepository = new ArticleRepository();
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