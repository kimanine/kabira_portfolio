<?php
require_once __DIR__ . '/../../services/SkillService.php';

class SkillController {
    public function __construct(private readonly SkillService $skillService) {
    }

    public function getAllSkills($limit = 25, $page = 1) {
        return $this->skillService->getAllSkills($limit, $page);
    }

    public function getTotalSkills() {
        return $this->skillService->getTotalSkills();
    }

    public function getSkillById($id) {
        return $this->skillService->getSkillById($id);
    }

    public function createSkill($data): bool
    {
        return $this->skillService->createSkill($data);
    }

    public function updateSkill($id, $data): bool
    {
        return $this->skillService->updateSkill($id, $data);
    }

    public function deleteSkill($id): bool
    {
        return $this->skillService->deleteSkill($id);
    }
}
