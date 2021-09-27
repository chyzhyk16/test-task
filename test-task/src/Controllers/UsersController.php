<?php

namespace App\Controllers;

use App\Service\DBService;
use App\Service\UsersService;

class UsersController extends BaseApiController
{
    private UsersService $usersService;

    public function __construct(UsersService $usersService)
    {
        $this->usersService = $usersService;
    }

    public function index()
    {
        $users = $this->usersService->getUsers();
        if ($users){
            return json_encode($users);
        } else {
            return json_encode([
                'message' => 'Users not found'
            ]);
        }
    }

    public function create()
    {
        if ($this->usersService->createUser($this->request_params)) {
            return json_encode([
                'message' => 'User has been created'
            ]);
        } else {
            return json_encode([
                'message' => 'User hasn`t been created'
            ]);
        }
    }

    public function read()
    {
        $user = $this->usersService->findUser($this->request_params['id']);
        if ($user){
            return json_encode($user);
        } else {
            return json_encode([
                'message' => 'User not found'
            ]);
        }
    }

    public function update()
    {
        if ($this->usersService->updateUser($this->request_params)) {
            return json_encode([
                'message' => 'User has been updated'
            ]);
        } else {
            return json_encode([
                'message' => 'User hasn`t been updated'
            ]);
        }
    }

    public function delete()
    {
        if ($this->usersService->deleteUser($this->request_params['id'])) {
            return json_encode([
                'message' => 'User has been deleted'
            ]);
        } else {
            return json_encode([
                'message' => 'User hasn`t been deleted'
            ]);
        }
    }
}