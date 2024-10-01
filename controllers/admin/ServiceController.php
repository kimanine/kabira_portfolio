<?php
require_once __DIR__ . '/../../services/ServiceService.php';

class ServiceController {
    public function __construct(private readonly ServiceService $serviceService) {
    }

    public function getAllServices($limit = null, $offset = null) {
        return $this->serviceService->getAllServices();
    }

    public function getTotalServices() {
        return $this->serviceService->getTotalServices();
    }

    public function getServiceById($id) {
        return $this->serviceService->getServiceById($id);
    }

    public function createService($data) {
        return $this->serviceService->createService($data);
    }

    public function updateService($id, $data) {
        return $this->serviceService->updateService($id, $data);
    }

    public function deleteService($id) {
        return $this->serviceService->deleteService($id);
    }
}
