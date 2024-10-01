<?php
require_once __DIR__ . '/../models/Team.php';

class TeamService {
    public function __construct(private readonly Team $team) {
    }

    public function getAllTeams($limit, $offset) {
        $query = "SELECT teams.*, profils.name AS profil_name 
              FROM teams 
              LEFT JOIN profils ON teams.profils_id_profil = profils.id_profil 
              LIMIT :limit OFFSET :offset";

        $stmt = $this->team->getConnection()->prepare($query);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function getTotalTeams() {
        $query = "SELECT COUNT(*) as total FROM " . $this->team->getTableName();
        $stmt = $this->team->getConnection()->query($query);
        return $stmt->fetch(PDO::FETCH_OBJ)->total;
    }

    public function getTeamById($id) {
        $query = "SELECT * FROM " . $this->team->getTableName() . " WHERE id_team = :id";
        $stmt = $this->team->getConnection()->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function createTeam($data) {
        $query = "INSERT INTO " . $this->team->getTableName() . " 
                  (picture, profils_id_profil) 
                  VALUES (:picture, :profils_id_profil)";
        $stmt = $this->team->getConnection()->prepare($query);

        $stmt->bindParam(':picture', $data['picture']);
        $stmt->bindParam(':profils_id_profil', $data['profils_id_profil']);

        return $stmt->execute();
    }

    public function updateTeam($id, $data) {
        $query = "UPDATE " . $this->team->getTableName() . " 
                  SET picture = :picture 
                  WHERE id_team = :id";
        $stmt = $this->team->getConnection()->prepare($query);

        $stmt->bindParam(':picture', $data['picture']);
        $stmt->bindParam(':id', $id);

        return $stmt->execute();
    }

    public function deleteTeam($id): bool
    {
        $member = $this->getTeamById($id);

        if ($member) {
            $imagePath = __DIR__ . '/../uploads/teams/' . $member->picture;

            if (is_file($imagePath)) {
                unlink($imagePath);
            }

            $query = "DELETE FROM " . $this->team->getTableName() . " WHERE id_team = :id";
            $stmt = $this->team->getConnection()->prepare($query);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            return $stmt->execute();
        }

        return false;
    }
}
