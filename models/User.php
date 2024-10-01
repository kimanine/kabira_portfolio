<?php
require_once __DIR__ . '/../config/database.php';

class User {
    private $conn;
    private $table_name = "users";

    public $user_id;
    public $username;
    public $first_name;
    public $last_name;

    public function __construct() {
        $this->conn = (new Database())->getConnection();
    }

    public function getTableName(): string
    {
        return $this->table_name;
    }

    public function getConnection(): \PDO
    {
        return $this->conn;
    }
}
