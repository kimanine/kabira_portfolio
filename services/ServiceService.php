<?php
require_once __DIR__ . '/../models/Service.php';

class ServiceService {
    private Service $service;

    public function __construct(Service $service) {
        $this->service = $service;
    }

    public function getAllServices() {
        $query = "SELECT services.*, profils.name AS profil_name 
              FROM " . $this->service->getTableName() . " 
              LEFT JOIN profils ON services.profils_id_profil = profils.id_profil";
        return $this->service->getConnection()->query($query)->fetchAll(PDO::FETCH_OBJ);
    }

    public function getTotalServices() {
        $query = "SELECT COUNT(*) as total FROM " . $this->service->getTableName();
        $stmt = $this->service->getConnection()->query($query);
        return $stmt->fetch(PDO::FETCH_OBJ)->total;
    }

    public function getServiceById($id) {
        $query = "SELECT * FROM " . $this->service->getTableName() . " WHERE id_service = :id";
        $stmt = $this->service->getConnection()->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function createService($data) {
        $query = "INSERT INTO " . $this->service->getTableName() . " 
                  (name, price, description, profils_id_profil) 
                  VALUES (:name, :price, :description, :profils_id_profil)";
        $stmt = $this->service->getConnection()->prepare($query);

        $stmt->bindParam(':name', $data['name']);
        $stmt->bindParam(':price', $data['price']);
        $stmt->bindParam(':description', $data['description']);
        $stmt->bindParam(':profils_id_profil', $data['profils_id_profil']);

        return $stmt->execute();
    }

    public function updateService($id, $data) {
        $query = "UPDATE " . $this->service->getTableName() . " 
                  SET name = :name, price = :price, description = :description 
                  WHERE id_service = :id";
        $stmt = $this->service->getConnection()->prepare($query);

        $stmt->bindParam(':name', $data['name']);
        $stmt->bindParam(':price', $data['price']);
        $stmt->bindParam(':description', $data['description']);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function deleteService($id) {
        $query = "DELETE FROM " . $this->service->getTableName() . " WHERE id_service = :id";
        $stmt = $this->service->getConnection()->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
