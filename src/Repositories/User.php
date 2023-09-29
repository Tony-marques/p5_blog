<?php

namespace Repositories;

use app\Db;
use models\UserModel;

class User
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
            $userModel = new UserModel();
            $this->hydrate($userModel, $comment);
            $result[] = $userModel;
        }

        return $result;
    }


    public function findOne(int $id) // OK
    {
        $sql = "SELECT * FROM users WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);

        $userModel = new userModel();
        $this->hydrate($userModel, $stmt->fetch());
        return $userModel;
    }

    public function update($post, $files, $user)
    {
//        UtilService::beautifulArray($user);
        $firstname = htmlspecialchars($post["firstname"]);
        $lastname = htmlspecialchars($post["lastname"]);
        $age = htmlspecialchars($post["age"]);
        $avatar = htmlspecialchars($files["avatar"]);

        $sql = "UPDATE users SET firstname = ?, lastname = ?, age = ?, avatar = ? WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$firstname, $lastname, $age, $user->getAvatar(), $user->getId()]);
    }
}