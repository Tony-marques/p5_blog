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

    /**
     * Hydrate article model
     * @param $article
     * @param $data
     * @return Article
     */
    private function hydrate($article, $data): Article
    {
        foreach ($data as $key => $value) {
            $method = 'set' . ucfirst($key);
            if (method_exists($article, $method)) {
                $article->$method($value);
            }
        }
        return $article;
    }

    /**
     * Find one article in database
     * @param int|null $id
     * @return Article
     */
    public function findOne(int $id = null): Article
    {
        $sql = "SELECT * FROM articles WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);

        $articleModel = new Article();
        $this->hydrate($articleModel, (array)$stmt->fetch());
        return $articleModel;
    }

    /**
     * Find all articles in database
     * @return array
     */
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

    /**
     * Crate new article in database
     * @param $post
     * @return void
     */
    public function create($post): void
    {
        $title = htmlspecialchars($post["title"]);
        $content = htmlspecialchars($post["content"]);
        $chapo = htmlspecialchars($post["chapo"]);

        $sql = "INSERT INTO articles(`title`, `content`, `chapo`, `userId`) VALUES(?, ?, ?, ?)";
        $statement = $this->db->prepare($sql);
        $statement->execute([$title, $content, $chapo, $_SESSION["user"]["id"]]);
    }

    /**
     * Update article in database
     * @param $post
     * @param $article
     * @return void
     */
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

    /**
     * Delete article in database
     * @param $id
     * @return void
     */
    public function deleteArticle($id): void
    {
        $sql = "DELETE FROM articles WHERE id = ?";

        $statement = $this->db->prepare($sql);
        $statement->execute([$id]);

        \header("location: /articles");
        return;
    }
}