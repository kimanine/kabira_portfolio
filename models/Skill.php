<?php
require_once __DIR__ . '/../config/database.php';

class Skill {
    private $conn;
    private $table_name = "skills";

    public $id_competence;
    public $name;
    public $color;
    public $percentage;
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