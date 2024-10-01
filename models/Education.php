<?php
require_once __DIR__ . '/../config/database.php';

class Education {
    private $conn;
    private $table_name = "educations";

    public $id_education;
    public $degree;
    public $date_start;
    public $date_end;
    public $institution_name;
    public $institution_address;
    public $description;
    public $profils_id_profil;

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
