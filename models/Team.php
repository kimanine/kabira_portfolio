<?php
require_once __DIR__ . '/../config/database.php';

class Team {
    private $conn;
    private $table_name = "teams";

    public $id_team;
    public $picture;
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
