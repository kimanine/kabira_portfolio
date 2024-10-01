<?php
require_once __DIR__ . '/../models/User.php';

class UserService {
    public function __construct(private readonly User $user) {
    }

    public function getAllUsers($limit = 25, $offset = 0) {
        $query = "SELECT * FROM " . $this->user->getTableName() . " LIMIT :limit OFFSET :offset";
        $stmt = $this->user->getConnection()->prepare($query);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function getUserById($id) {
        $query = "SELECT * FROM " . $this->user->getTableName() . " WHERE user_id = :id";
        $stmt = $this->user->getConnection()->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function getUserByUsername($username) {
        $query = "SELECT * FROM " . $this->user->getTableName() . " WHERE username = :username LIMIT 1";
        $stmt = $this->user->getConnection()->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function createUser($data): bool {
        $query = "INSERT INTO " . $this->user->getTableName() . " 
                  (username, first_name, last_name, password) 
                  VALUES (:username, :first_name, :last_name, :password)";
        $stmt = $this->user->getConnection()->prepare($query);

        $stmt->bindParam(':username', $data['username']);
        $stmt->bindParam(':first_name', $data['first_name']);
        $stmt->bindParam(':last_name', $data['last_name']);
        $stmt->bindParam(':password', $data['password']);
        return $stmt->execute();
    }

    public function updateUser($id, $data): bool {
        $query = "UPDATE " . $this->user->getTableName() . " 
                  SET username = :username, first_name = :first_name, last_name = :last_name 
                  WHERE user_id = :id";
        $stmt = $this->user->getConnection()->prepare($query);

        $stmt->bindParam(':username', $data['username']);
        $stmt->bindParam(':first_name', $data['first_name']);
        $stmt->bindParam(':last_name', $data['last_name']);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function deleteUser($id): bool {
        $query = "DELETE FROM " . $this->user->getTableName() . " WHERE user_id = :id";
        $stmt = $this->user->getConnection()->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function getTotalUsers() {
        $query = "SELECT COUNT(*) as total FROM " . $this->user->getTableName();
        $stmt = $this->user->getConnection()->query($query);

        return $stmt->fetch(PDO::FETCH_OBJ)->total;
    }
}
