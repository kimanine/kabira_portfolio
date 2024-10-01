<?php
require_once __DIR__ . '/../config/database.php';

class Service {
    private $conn;
    private $table_name = "services";

    public $id_service;
    public $name;
    public $price;
    public $description;
    public $profils_id_profil;

    public function __construct() {
        $this->conn = (new Database())->getConnection();
    }

    public function getTableName() {
        return $this->table_name;
    }

    public function getConnection() {
        return $this->conn;
    }
}
