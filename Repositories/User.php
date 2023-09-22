<?php

namespace App\Repositories;

use App\app\Db;
use App\models\UserModel;

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

    public function findOne(int $id) // OK
    {
        $sql = "SELECT * FROM users WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);

        $userModel = new userModel();
        $this->hydrate($userModel, $stmt->fetch());
        return $userModel;
    }
}