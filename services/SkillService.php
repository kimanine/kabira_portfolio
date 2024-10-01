<?php
require_once __DIR__ . '/../models/Skill.php';

class SkillService {
    public function __construct(private Skill $skill) {
    }

    public function getAllSkills($limit, $offset) {
        $query = "SELECT s.*, p.name AS profil_name 
              FROM " . $this->skill->getTableName() . " s 
              LEFT JOIN profils p ON s.profils_id_profil = p.id_profil 
              LIMIT :limit OFFSET :offset";

        $stmt = $this->skill->getConnection()->prepare($query);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function getTotalSkills() {
        $query = "SELECT COUNT(*) as total FROM " . $this->skill->getTableName();
        $stmt = $this->skill->getConnection()->query($query);
        return $stmt->fetch(PDO::FETCH_OBJ)->total;
    }

    public function getSkillById($id) {
        $query = "SELECT * FROM " . $this->skill->getTableName() . " WHERE id_competence = :id";
        $stmt = $this->skill->getConnection()->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function createSkill($data) {
        $query = "INSERT INTO " . $this->skill->getTableName() . " 
                  (name, color, percentage, profils_id_profil) 
                  VALUES (:name, :color, :percentage, :profils_id_profil)";
        $stmt = $this->skill->getConnection()->prepare($query);

        $stmt->bindParam(':name', $data['name']);
        $stmt->bindParam(':color', $data['color']);
        $stmt->bindParam(':percentage', $data['percentage']);
        $stmt->bindParam(':profils_id_profil', $data['profils_id_profil']);

        return $stmt->execute();
    }

    public function updateSkill($id, $data) {
        $query = "UPDATE " . $this->skill->getTableName() . " 
                  SET name = :name, color = :color, percentage = :percentage 
                  WHERE id_competence = :id";
        $stmt = $this->skill->getConnection()->prepare($query);

        $stmt->bindParam(':name', $data['name']);
        $stmt->bindParam(':color', $data['color']);
        $stmt->bindParam(':percentage', $data['percentage']);
        $stmt->bindParam(':id', $id);

        return $stmt->execute();
    }

    public function deleteSkill($id) {
        $query = "DELETE FROM " . $this->skill->getTableName() . " WHERE id_competence = :id";
        $stmt = $this->skill->getConnection()->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
