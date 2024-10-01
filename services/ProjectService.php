<?php
require_once __DIR__ . '/../models/Project.php';

class ProjectService {
    public function __construct(private readonly Project $project) {
    }

    public function getAllProjects($limit, $offset) {
        $query = "SELECT projects.*, profils.name AS profil_name 
              FROM projects 
              LEFT JOIN profils ON projects.profils_id_profil = profils.id_profil 
              LIMIT :limit OFFSET :offset";

        $stmt = $this->project->getConnection()->prepare($query);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function getTotalProjects() {
        $query = "SELECT COUNT(*) as total FROM " . $this->project->getTableName();
        $stmt = $this->project->getConnection()->query($query);
        return $stmt->fetch(PDO::FETCH_OBJ)->total;
    }

    public function getProjectById($id) {
        $query = "SELECT * FROM " . $this->project->getTableName() . " WHERE id_project = :id";
        $stmt = $this->project->getConnection()->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function createProject($data): bool
    {
        $query = "INSERT INTO " . $this->project->getTableName() . " 
                  (picture, profils_id_profil) 
                  VALUES (:picture, :profils_id_profil)";
        $stmt = $this->project->getConnection()->prepare($query);

        $stmt->bindParam(':picture', $data['picture']);
        $stmt->bindParam(':profils_id_profil', $data['profils_id_profil']);

        return $stmt->execute();
    }

    public function updateProject($id, $data): bool
    {
        $query = "UPDATE " . $this->project->getTableName() . " 
                  SET picture = :picture 
                  WHERE id_project = :id";
        $stmt = $this->project->getConnection()->prepare($query);

        $stmt->bindParam(':picture', $data['picture']);
        $stmt->bindParam(':id', $id);

        return $stmt->execute();
    }

    public function deleteProject($id): bool
    {
        $project = $this->getProjectById($id);

        if ($project) {
            $imagePath = __DIR__ . '/../uploads/projects/' . $project->picture;

            if (is_file($imagePath)) {
                unlink($imagePath);
            }

            $query = "DELETE FROM " . $this->project->getTableName() . " WHERE id_project = :id";
            $stmt = $this->project->getConnection()->prepare($query);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            return $stmt->execute();
        }
        return false;
    }
}
