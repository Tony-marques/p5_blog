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

    /**
     * Hydrate user model
     * @param User $user
     * @param array|object $data
     * @return User
     */
    private function hydrate(User $user, array|object $data = []): User
    {
        foreach ($data as $key => $value) {
            $method = 'set' . ucfirst($key);
            if (method_exists($user, $method)) {
                $user->$method($value);
            }
        }
        return $user;
    }

    /**
     * Find user in database by criteria array
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


    /**
     * Find one user in database
     * @param int|null $id
     * @return User
     */
    public function findOne(int $id = null): User
    {
        $sql = "SELECT * FROM users WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);

        $userModel = new User();
        $this->hydrate($userModel, (array)$stmt->fetch());

        return $userModel;
    }

    /**
     * Update user in database
     * @param array $post
     * @param array $files
     * @param User $user
     * @return void
     */
    public function update(array $post, array $files, User $user):void
    {
        $firstname = htmlspecialchars($post["firstname"]);
        $lastname = htmlspecialchars($post["lastname"]);
        $age = htmlspecialchars($post["age"]);
        $avatar = htmlspecialchars($files["avatar"]);

        $sql = "UPDATE users SET firstname = ?, lastname = ?, age = ?, avatar = ? WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$firstname, $lastname, $age, $user->getAvatar(), $user->getId()]);
    }

    /**
     * Delete user in database
     * @param int $id
     * @return void
     */
    public function delete(int $id): void{
        $sql = "DELETE FROM users WHERE id = ?";
        $statement = $this->db->prepare($sql);
        $statement->execute([$id]);
    }
}