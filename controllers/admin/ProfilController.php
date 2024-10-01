<?php
require_once __DIR__ . '/../../services/ProfilService.php';

class ProfilController {
    public function __construct(private readonly ProfilService $profilService) {}

    public function getAllProfils($limit = 25, $page = 1) {
        $offset = ($page - 1) * $limit;
        return $this->profilService->getAllProfils($limit, $offset);
    }

    public function getTotalProfils()
    {
        return $this->profilService->getTotalProfils();
    }

    public function getProfilById(int $id) {
        return $this->profilService->getProfilById($id);
    }

    public function createProfil(array $data) {
        return $this->profilService->createProfil($data);
    }

    public function updateProfil(int $id, array $data) {
        return $this->profilService->updateProfil($id, $data);
    }

    public function deleteProfil(int $id) {
        return $this->profilService->deleteProfil($id);
    }
}