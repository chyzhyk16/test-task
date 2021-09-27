<?php

namespace App\Service;

use App\Entity\User;
use App\Repository\UserRepository;

class UsersService
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @return array|bool
     */
    public function getUsers()
    {
        $data = $this->userRepository->getAllUsers();
        if ($data) {
            $users = [];
            foreach ($data as $datum) {
                $users[] = $datum->getAttributes();
            }
            return $users;
        } else {
            return false;
        }
    }

    /**
     * @param int $id
     * @return string[]
     */
    public function findUser(int $id): array
    {
        $user = $this->userRepository->getUser($id);
        if ($user) {
            return $user->getAttributes();
        } else {
            return [
                'message' => 'User not found'
            ];
        }
    }

    public function createUser(array $fields)
    {
        try {
            $user = new User();
            $user->setName($fields['name']);
            $user->setEmail($fields['email']);
            $user->setBirthDate($fields['birth_date']);
            $user->setSex($fields['sex']);
            if ($user->validateAttributes()) {
                return $this->userRepository->saveUser($user);
            } else {
                return false;
            }
        } catch (\Exception $exception) {
            return false;
        }
    }

    public function updateUser(array $fields)
    {
        try {
            $user = $this->userRepository->getUser($fields['id']);
            if (isset($fields['name'])) {
                $user->setName($fields['name']);
            }
            if (isset($fields['email'])) {
                $user->setEmail($fields['email']);
            }
            if (isset($fields['birth_date'])) {
                $user->setBirthDate($fields['birth_date']);
            }
            if (isset($fields['sex'])) {
                $user->setSex($fields['sex']);
            }
            if ($user->validateAttributes()) {
                return $this->userRepository->updateUser($user);
            } else {
                return false;
            }
        } catch (\Exception $exception) {
            return false;
        }
    }

    public function deleteUser(int $id)
    {
        return $this->userRepository->deleteUser($id);
    }
}