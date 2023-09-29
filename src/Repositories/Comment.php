<?php

namespace Repositories;

use app\Db;
use models\CommentModel;

class Comment
{
    private Db $db;

    public function __construct()
    {
        $this->db = Db::getInstance();
    }

    private function hydrate($comment, $data) // OK
    {
        foreach ($data as $cle => $valeur) {
            $methode = 'set' . ucfirst($cle);
            if (method_exists($comment, $methode)) {
                $comment->$methode($valeur);
            }
        }
        return $comment;
    }

    public function findOne(int $id) // OK
    {
        $sql = "SELECT * FROM comments WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);

        $commentModel = new CommentModel();
        $this->hydrate($commentModel, $stmt->fetch());
        return $commentModel;
    }

    public function createComment($post, $articleId, $isAdmin) // OK
    {
        $sql = "INSERT INTO comments(`content`, `articleId`, `userId`, `published`) VALUES(?, ?, ?, ?)";

        $comment = htmlspecialchars($post["comment"]);
        $userRepository = new User();
        $user = $userRepository->findOne($_SESSION["user"]["id"]);
        $commentModel = new CommentModel();
        $commentModel->setContent($comment)
            ->setArticleId($articleId)
            ->setUserId($_SESSION["user"]["id"])
            ->setUser($user)
            ->setPublished($isAdmin ? true : 0);
//        UtilService::beautifulArray($commentModel);

        $statement = $this->db->prepare($sql);
        $statement->execute([$commentModel->getContent(), $commentModel->getArticleId(), $commentModel->getUserId(), $commentModel->getPublished()]);

        \header("location: /article/{$commentModel->getArticleId()}");
        return;
    }

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
            $commentModel = new CommentModel();
            $this->hydrate($commentModel, $comment);
            $result[] =  $commentModel;
        }

        return $result;
    }

    public function save($commentModel) // OK
    {
        $sql = "UPDATE comments SET content = ?, published = ?, articleId = ?, userId = ? WHERE id = ?";
        $statement = $this->db->prepare($sql);
        $statement->execute([$commentModel->getContent(), $commentModel->getPublished(), $commentModel->getArticleId(), $commentModel->getUserId(), $commentModel->getId()]);
    }

    public function deleteComment($id) // OK
    {
        $sql = "DELETE FROM comments WHERE id = ?";

        $statement = $this->db->prepare($sql);
        $statement->execute([$id]);
    }
}