<?php
require_once __DIR__ . '/../models/Education.php';

class EducationService
{
    public function __construct(private readonly Education $education)
    {
    }

    public function getAllEducations($limit = 25, $offset = 0)
    {
        $query = "SELECT e.*, p.name AS profil_name 
                  FROM " . $this->education->getTableName() . " e 
                  LEFT JOIN profils p ON e.profils_id_profil = p.id_profil 
                  LIMIT :limit OFFSET :offset";

        $stmt = $this->education->getConnection()->prepare($query);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function getEducationById($id)
    {
        $query = "SELECT * FROM " . $this->education->getTableName() . " WHERE id_education = :id";
        $stmt = $this->education->getConnection()->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function createEducation($data): bool
    {
        $query = "INSERT INTO " . $this->education->getTableName() . " 
                  (degree, date_start, date_end, institution_name, institution_address, description, profils_id_profil) 
                  VALUES (:degree, :date_start, :date_end, :institution_name, :institution_address, :description, :profils_id_profil)";

        $stmt = $this->education->getConnection()->prepare($query);

        $stmt->bindParam(':degree', $data['degree']);
        $stmt->bindParam(':date_start', $data['date_start']);
        $stmt->bindParam(':date_end', $data['date_end']);
        $stmt->bindParam(':institution_name', $data['institution_name']);
        $stmt->bindParam(':institution_address', $data['institution_address']);
        $stmt->bindParam(':description', $data['description']);
        $stmt->bindParam(':profils_id_profil', $data['profils_id_profil'], PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function updateEducation($id, $data): bool
    {
        $query = "UPDATE " . $this->education->getTableName() . " 
                  SET degree = :degree, date_start = :date_start, date_end = :date_end, 
                      institution_name = :institution_name, institution_address = :institution_address, 
                      description = :description, profils_id_profil = :profils_id_profil 
                  WHERE id_education = :id";

        $stmt = $this->education->getConnection()->prepare($query);

        $stmt->bindParam(':degree', $data['degree']);
        $stmt->bindParam(':date_start', $data['date_start']);
        $stmt->bindParam(':date_end', $data['date_end']);
        $stmt->bindParam(':institution_name', $data['institution_name']);
        $stmt->bindParam(':institution_address', $data['institution_address']);
        $stmt->bindParam(':description', $data['description']);
        $stmt->bindParam(':profils_id_profil', $data['profils_id_profil'], PDO::PARAM_INT);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function deleteEducation($id): bool
    {
        $query = "DELETE FROM " . $this->education->getTableName() . " WHERE id_education = :id";
        $stmt = $this->education->getConnection()->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function getTotalEducations(): int
    {
        $query = "SELECT COUNT(*) as total FROM " . $this->education->getTableName();
        $stmt = $this->education->getConnection()->query($query);

        return $stmt->fetch(PDO::FETCH_OBJ)->total;
    }
}
