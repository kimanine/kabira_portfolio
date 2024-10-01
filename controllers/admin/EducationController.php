<?php
require_once __DIR__ . '/../../services/EducationService.php';

class EducationController
{
    public function __construct(private readonly EducationService $educationService)
    {
    }

    public function getAllEducations($limit = 25, $page = 1)
    {
        $offset = ($page - 1) * $limit;
        return $this->educationService->getAllEducations($limit, $offset);
    }

    public function getEducationById($id)
    {
        return $this->educationService->getEducationById($id);
    }

    public function createEducation($data)
    {
        return $this->educationService->createEducation($data);
    }

    public function updateEducation($id, $data)
    {
        return $this->educationService->updateEducation($id, $data);
    }

    public function deleteEducation($id)
    {
        return $this->educationService->deleteEducation($id);
    }

    public function getTotalEducations()
    {
        return $this->educationService->getTotalEducations();
    }
}
