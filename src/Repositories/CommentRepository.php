<?php

namespace App\Repositories;

use App\App\Db;
use App\Models\Comment;
use App\Services\UtilService;

class CommentRepository
{
    private Db $db;

    public function __construct()
    {
        $this->db = Db::getInstance();
    }

    /**
     * Hydrate comment model
     * @param Comment $comment
     * @param array|object $data
     * @return Comment
     */
    private function hydrate(Comment $comment, array|object $data): Comment
    {
        foreach ($data as $key => $value) {
            $method = 'set' . ucfirst($key);
            if (method_exists($comment, $method)) {
                $comment->$method($value);
            }
        }
        return $comment;
    }

    /**
     * Find one comment in database
     * @param int $id
     * @return Comment
     */
    public function findOne(int $id): Comment
    {
        $sql = "SELECT * FROM comments WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);

        $commentModel = new Comment();
        $this->hydrate($commentModel, $stmt->fetch());

        return $commentModel;
    }

    /**
     * Create comment in database
     * @param array $post
     * @param string $articleId
     * @param bool $isAdmin
     * @return void
     */
    public function createComment(array $post, string $articleId, bool $isAdmin): void
    {
        $sql = "INSERT INTO comments(`content`, `articleId`, `userId`, `published`) VALUES(?, ?, ?, ?)";

        $comment = filter_var($post["comment"], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $userRepository = new UserRepository();
        $user = $userRepository->findOne($_SESSION["user"]["id"]);
        $commentModel = new Comment();
        $commentModel->setContent($comment)
            ->setArticleId($articleId)
            ->setUserId($_SESSION["user"]["id"])
            ->setUser($user)
            ->setPublished($isAdmin ? true : 0);

        $statement = $this->db->prepare($sql);
        $statement->execute([$commentModel->getContent(), $commentModel->getArticleId(), $commentModel->getUserId(), $commentModel->getPublished()]);

        \header("location: /article/{$commentModel->getArticleId()}");
        return;
    }

    /**
     * find comments by criteria array
     * @param array $arr
     * @return array
     */
    public function findBy(array $arr): array
    {
        $keys = [];
        $values = [];

        foreach ($arr as $key => $value) {
            $keys[] = "$key = ?";
            $values[] = $value;
        }

        $list_keys = implode(" AND ", $keys);

        $sql = "SELECT * FROM comments WHERE $list_keys";


        $stmt = $this->db->prepare($sql);
        $stmt->execute($values);

        $result = [];
        foreach ($stmt->fetchall() as $comment) {
            $commentModel = new Comment();
            $this->hydrate($commentModel, $comment);

            $userRepository = new UserRepository();
            $user = $userRepository->findOne($commentModel->getUserId());
            $commentModel->setUser($user);

            $result[] = $commentModel;
        }

        return $result;
    }

    /**
     * Update comment in database
     * @param Comment $commentModel
     * @return void
     */
    public function save(Comment $commentModel): void
    {
        $sql = "UPDATE comments SET content = ?, published = ?, articleId = ?, userId = ? WHERE id = ?";
        $statement = $this->db->prepare($sql);
        $statement->execute([$commentModel->getContent(), $commentModel->getPublished(), $commentModel->getArticleId(), $commentModel->getUserId(), $commentModel->getId()]);
    }

    /**
     * Delete comment in database
     * @param string $id
     * @return void
     */
    public function deleteComment(string $id): void
    {
        $sql = "DELETE FROM comments WHERE id = ?";

        $statement = $this->db->prepare($sql);
        $statement->execute([$id]);
    }
}