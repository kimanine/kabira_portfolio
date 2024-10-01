<?php

namespace controllers\admin;
use UserService;

require_once __DIR__ . '/../../services/UserService.php';

class UserController
{
    public function __construct(private readonly UserService $userService)
    {
    }

    public function getAllUsers($limit = 25, $page = 1)
    {
        $offset = ($page - 1) * $limit;
        return $this->userService->getAllUsers($limit, $offset);
    }

    public function getUserById($id)
    {
        return $this->userService->getUserById($id);
    }

    public function createUser($data): bool
    {
        return $this->userService->createUser($data);
    }

    public function updateUser($id, $data): bool
    {
        return $this->userService->updateUser($id, $data);
    }

    public function deleteUser($id): bool
    {
        return $this->userService->deleteUser($id);
    }

    public function getTotalUsers()
    {
        return $this->userService->getTotalUsers();
    }
}
