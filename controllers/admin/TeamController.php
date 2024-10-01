<?php
require_once __DIR__ . '/../../services/TeamService.php';

class TeamController {
    public function __construct(private readonly TeamService $teamService) {}

    public function getAllTeams($limit = 25, $page = 1) {
        $offset = ($page - 1) * $limit;
        return $this->teamService->getAllTeams($limit, $offset);
    }

    public function getTeamById(int $id) {
        return $this->teamService->getTeamById($id);
    }

    public function createTeam(array $data) {
        return $this->teamService->createTeam($data);
    }

    public function updateTeam(int $id, array $data) {
        return $this->teamService->updateTeam($id, $data);
    }

    public function deleteTeam(int $id) {
        return $this->teamService->deleteTeam($id);
    }

    public function getTotalTeams() {
        return $this->teamService->getTotalTeams();
    }
}
