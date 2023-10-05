<?php

namespace App\Repositories;

use App\App\Db;
use App\Models\User;

class UserRepository
{
    private Db $db;

    public function __construct()
    {
        $this->db = Db::getInstance();
    }

    private function hydrate($comment, $data = []) // OK
    {
        foreach ($data as $cle => $valeur) {
            $methode = 'set' . ucfirst($cle);
            if (method_exists($comment, $methode)) {
                $comment->$methode($valeur);
            }
        }
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

        $sql = "SELECT * FROM users WHERE $list_keys";

        $stmt = $this->db->prepare($sql);
        $stmt->execute($values);

        $result = [];
        foreach ($stmt->fetchall() as $comment) {
            $userModel = new User();
            $this->hydrate($userModel, $comment);
            $result[] = $userModel;
        }

        return $result;
    }


    public function findOne(int $id = null) // OK
    {
        $sql = "SELECT * FROM users WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);

        $userModel = new User();
        $this->hydrate($userModel, (array)$stmt->fetch());
        return $userModel;
    }

    public function update($post, $files, $user)
    {
        $firstname = htmlspecialchars($post["firstname"]);
        $lastname = htmlspecialchars($post["lastname"]);
        $age = htmlspecialchars($post["age"]);
        $avatar = htmlspecialchars($files["avatar"]);

        $sql = "UPDATE users SET firstname = ?, lastname = ?, age = ?, avatar = ? WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$firstname, $lastname, $age, $user->getAvatar(), $user->getId()]);
    }

    public function delete(int $id): void{
        $sql = "DELETE FROM users WHERE id = ?";
        $statement = $this->db->prepare($sql);
        $statement->execute([$id]);
    }
}