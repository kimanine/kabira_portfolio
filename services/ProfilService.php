<?php
require_once __DIR__ . '/../models/Profil.php';

class ProfilService
{
    public function __construct(private readonly Profil $profil)
    {
    }

    public function getAllProfils($limit = 25, $offset = 0)
    {
        $query = "SELECT * FROM " . $this->profil->getTableName() . " LIMIT :limit OFFSET :offset";
        $stmt = $this->profil->getConnection()->prepare($query);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function getProfilById($id)
    {
        $query = "SELECT * FROM " . $this->profil->getTableName() . " WHERE id_profil = :id";
        $stmt = $this->profil->getConnection()->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function createProfil($data): bool
    {
        $query = "INSERT INTO " . $this->profil->getTableName() . " 
                  (name, email, phone_number, address, picture, cv, description, skill_description) 
                  VALUES (:name, :email, :phone_number, :address, :picture, :cv, :description, :skill_description)";
        $stmt = $this->profil->getConnection()->prepare($query);

        $stmt->bindParam(':name', $data['name']);
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':phone_number', $data['phone_number']);
        $stmt->bindParam(':address', $data['address']);
        $stmt->bindParam(':picture', $data['picture']);
        $stmt->bindParam(':cv', $data['cv']);
        $stmt->bindParam(':description', $data['description']);
        $stmt->bindParam(':skill_description', $data['skill_description']);

        return $stmt->execute();
    }

    public function updateProfil($id, $data): bool
    {
        $profil = $this->getProfilById($id);

        if ($profil) {
            if (!empty($data['picture'])) {
                $imagePath = __DIR__ . '/../uploads/profils/images/' . $profil->picture;
                if (!empty($profil->picture) && is_file($imagePath)) {
                    unlink($imagePath);
                }
            } else {
                $data['picture'] = $profil->picture;
            }

            if (!empty($data['cv'])) {
                $cvPath = __DIR__ . '/../uploads/profils/resumes/' . $profil->cv;
                if (!empty($profil->cv) && is_file($cvPath)) {
                    unlink($cvPath);
                }
            } else {
                $data['cv'] = $profil->cv;
            }
        }

        $query = "UPDATE " . $this->profil->getTableName() . " 
          SET name = :name, email = :email, phone_number = :phone_number, address = :address, 
              picture = :picture, cv = :cv, description = :description, skill_description = :skill_description 
          WHERE id_profil = :id";
        $stmt = $this->profil->getConnection()->prepare($query);

        $stmt->bindParam(':name', $data['name']);
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':phone_number', $data['phone_number']);
        $stmt->bindParam(':address', $data['address']);
        $stmt->bindParam(':picture', $data['picture']);
        $stmt->bindParam(':cv', $data['cv']);
        $stmt->bindParam(':description', $data['description']);
        $stmt->bindParam(':skill_description', $data['skill_description']);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function deleteProfil($id): bool
    {
        $profil = $this->getProfilById($id);
        if ($profil) {
            if (!empty($profil->picture) && is_file(__DIR__ . '/../uploads/profils/images/' . $profil->picture)) {
                unlink(__DIR__ . '/../uploads/profils/images/' . $profil->picture);
            }

            if (!empty($profil->cv) && is_file(__DIR__ . '/../uploads/profils/resumes/' . $profil->cv)) {
                unlink(__DIR__ . '/../uploads/profils/resumes/' . $profil->cv);
            }
        }

        $query = "DELETE FROM " . $this->profil->getTableName() . " WHERE id_profil = :id";
        $stmt = $this->profil->getConnection()->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function getTotalProfils()
    {
        $query = "SELECT COUNT(*) as total FROM " . $this->profil->getTableName();
        $stmt = $this->profil->getConnection()->query($query);

        return $stmt->fetch(PDO::FETCH_OBJ)->total;
    }
}
