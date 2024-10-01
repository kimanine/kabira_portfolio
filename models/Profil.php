<?php
require_once __DIR__ . '/../config/database.php';

class Profil
{
    private $conn;
    private $table_name = "profils";

    public $id_profil;
    public $name;
    public $email;
    public $phone_number;
    public $address;
    public $picture;
    public $cv;
    public $description;
    public $skill_description;

    public function __construct()
    {
        $this->conn = (new Database())->getConnection();
    }

    public function getTableName() {
        return $this->table_name;
    }

    public function getConnection() {
        return $this->conn;
    }
}