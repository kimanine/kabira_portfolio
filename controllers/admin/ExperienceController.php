<?php
require_once __DIR__ . '/../../services/ExperienceService.php';

class ExperienceController
{

    public function __construct(private readonly ExperienceService $experienceService)
    {
    }

    public function getAllExperiences($limit = 25, $page = 1)
    {
        $offset = ($page - 1) * $limit;
        return $this->experienceService->getAllExperiences($limit, $offset);
    }

    public function getExperienceById($id)
    {
        return $this->experienceService->getExperienceById($id);
    }

    public function createExperience($data): bool
    {
        return $this->experienceService->createExperience($data);
    }

    public function updateExperience($id, $data): bool
    {
        return $this->experienceService->updateExperience($id, $data);
    }

    public function deleteExperience($id): bool
    {
        return $this->experienceService->deleteExperience($id);
    }

    public function getTotalExperiences()
    {
        return $this->experienceService->getTotalExperiences();
    }
}
