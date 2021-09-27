<?php

namespace App\Repository;

use App\DB\DBConfig;
use App\DB\DBConnection;
use App\Entity\User;
use PDO;

class UserRepository
{
    private DBConnection $db;

    public function __construct(DBConnection $connection)
    {
        $this->db = $connection;
    }

    /**
     * @return array|false
     */
    public function getAllUsers()
    {
        $data = $this->db->connection->query("SELECT * FROM users")->fetchAll(PDO::FETCH_ASSOC);
        if ($data) {
            $users = [];
            foreach ($data as $values) {
                $user = new User();
                $user->setAttributes($values);
                $users[] = $user;
            }
            return $users;
        } else {
            return false;
        }
    }

    public function getUser(int $id)
    {
        $query = $this->db->connection->prepare("SELECT * FROM users WHERE `id` = ?");
        $query->execute([$id]);
        $data = $query->fetch(PDO::FETCH_LAZY);
        if ($data) {
            $user = new User();
            $user->setAttributes([
                'id' => $data->id,
                'name' => $data->name,
                'email' => $data->email,
                'birth_date' => $data->birth_date,
                'sex' => $data->sex,
            ]);
            return $user;
        } else {
            return false;
        }
    }

    public function saveUser(User $user)
    {
        $query = "INSERT INTO `users` (`id`, `name`, `email`, `birth_date`, `sex`) VALUES (NULL, :name, :email, :birth_date, :sex)";
        $params = [
            'name' => $user->getName(),
            'email' => $user->getEmail(),
            'birth_date' => $user->getBirthDate(),
            'sex' => $user->getSex(),
        ];
        $query = $this->db->connection->prepare($query);
        return $query->execute($params);
    }

    public function updateUser(User $user)
    {
        $query = "UPDATE `users` SET `name` = :name, `email` = :email, `birth_date` = :birth_date, `sex` = :sex WHERE `id` = :id";
        $params = [
            ':id' => $user->getId(),
            'name' => $user->getName(),
            'email' => $user->getEmail(),
            'birth_date' => $user->getBirthDate(),
            'sex' => $user->getSex(),
        ];
        $query = $this->db->connection->prepare($query);
        return $query->execute($params);

    }

    public function deleteUser(int $id)
    {
        $query = "DELETE FROM `users` WHERE `id` = ?";
        $params = [$id];
        $query = $this->db->connection->prepare($query);
        return $query->execute($params);
    }
}