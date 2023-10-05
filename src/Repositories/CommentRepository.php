<?php

namespace App\Repositories;

use App\App\Db;
use App\Models\Comment;

class CommentRepository
{
    private Db $db;

    public function __construct()
    {
        $this->db = Db::getInstance();
    }

    /**
     * Hydrate comment model
     * @param $comment
     * @param $data
     * @return mixed
     */
    private function hydrate($comment, $data)
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
    public function findOne(int $id)
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
     * @param $post
     * @param $articleId
     * @param $isAdmin
     * @return void
     */
    public function createComment($post, $articleId, $isAdmin)
    {
        $sql = "INSERT INTO comments(`content`, `articleId`, `userId`, `published`) VALUES(?, ?, ?, ?)";

        $comment = htmlspecialchars($post["comment"]);
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
    public function findBy(array $arr)
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
            $result[] =  $commentModel;
        }

        return $result;
    }

    /**
     * Update comment in database
     * @param $commentModel
     * @return void
     */
    public function save($commentModel)
    {
        $sql = "UPDATE comments SET content = ?, published = ?, articleId = ?, userId = ? WHERE id = ?";
        $statement = $this->db->prepare($sql);
        $statement->execute([$commentModel->getContent(), $commentModel->getPublished(), $commentModel->getArticleId(), $commentModel->getUserId(), $commentModel->getId()]);
    }

    /**
     * Delete comment in database
     * @param $id
     * @return void
     */
    public function deleteComment($id)
    {
        $sql = "DELETE FROM comments WHERE id = ?";

        $statement = $this->db->prepare($sql);
        $statement->execute([$id]);
    }
}