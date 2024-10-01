<?php
require_once __DIR__ . '/../../services/ProjectService.php';

class ProjectController {
    public function __construct(private readonly ProjectService $projectService) {
    }

    public function getAllProjects($limit = 25, $page = 1) {
        $offset = ($page - 1) * $limit;
        return $this->projectService->getAllProjects($limit, $offset);
    }

    public function getTotalProjects() {
        return $this->projectService->getTotalProjects();
    }

    public function getProjectById(int $id) {
        return $this->projectService->getProjectById($id);
    }

    public function createProject(array $data): bool
    {
        return $this->projectService->createProject($data);
    }

    public function updateProject(int $id, array $data) {
        return $this->projectService->updateProject($id, $data);
    }

    public function deleteProject(int $id): bool
    {
        return $this->projectService->deleteProject($id);
    }
}
