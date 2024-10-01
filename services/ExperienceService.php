<?php
require_once __DIR__ . '/../models/Experience.php';

class ExperienceService
{
    public function __construct(private readonly Experience $experience)
    {
    }

    public function getAllExperiences($limit = 25, $offset = 0)
    {
        $query = "
        SELECT experiences.*, profils.name AS profil_name
        FROM " . $this->experience->getTableName() . " AS experiences
        LEFT JOIN profils ON experiences.profils_id_profil = profils.id_profil
        LIMIT :limit OFFSET :offset
    ";

        $stmt = $this->experience->getConnection()->prepare($query);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function getExperienceById($id)
    {
        $query = "SELECT * FROM " . $this->experience->getTableName() . " WHERE id_experience = :id";
        $stmt = $this->experience->getConnection()->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function createExperience($data): bool
    {
        $query = "INSERT INTO " . $this->experience->getTableName() . " 
                  (job, date_start, date_end, company_name, company_address, description, profils_id_profil) 
                  VALUES (:job, :date_start, :date_end, :company_name, :company_address, :description, :profils_id_profil)";
        $stmt = $this->experience->getConnection()->prepare($query);

        $stmt->bindParam(':job', $data['job']);
        $stmt->bindParam(':date_start', $data['date_start']);
        $stmt->bindParam(':date_end', $data['date_end']);
        $stmt->bindParam(':company_name', $data['company_name']);
        $stmt->bindParam(':company_address', $data['company_address']);
        $stmt->bindParam(':description', $data['description']);
        $stmt->bindParam(':profils_id_profil', $data['profils_id_profil'], PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function updateExperience($id, $data): bool
    {
        $query = "UPDATE " . $this->experience->getTableName() . " 
                  SET job = :job, date_start = :date_start, date_end = :date_end, 
                      company_name = :company_name, company_address = :company_address, 
                      description = :description, profils_id_profil = :profils_id_profil 
                  WHERE id_experience = :id";
        $stmt = $this->experience->getConnection()->prepare($query);

        $stmt->bindParam(':job', $data['job']);
        $stmt->bindParam(':date_start', $data['date_start']);
        $stmt->bindParam(':date_end', $data['date_end']);
        $stmt->bindParam(':company_name', $data['company_name']);
        $stmt->bindParam(':company_address', $data['company_address']);
        $stmt->bindParam(':description', $data['description']);
        $stmt->bindParam(':profils_id_profil', $data['profils_id_profil'], PDO::PARAM_INT);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function deleteExperience($id): bool
    {
        $query = "DELETE FROM " . $this->experience->getTableName() . " WHERE id_experience = :id";
        $stmt = $this->experience->getConnection()->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function getTotalExperiences()
    {
        $query = "SELECT COUNT(*) as total FROM " . $this->experience->getTableName();
        $stmt = $this->experience->getConnection()->query($query);

        return $stmt->fetch(PDO::FETCH_OBJ)->total;
    }
}
