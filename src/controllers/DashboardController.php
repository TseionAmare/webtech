<?php
// src/controllers/DashboardController.php
require_once __DIR__ . '/../../config/connection.php';

class DashboardController {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getSensorData() {
        $stmt = $this->pdo->prepare("SELECT * FROM sensor_data ORDER BY timestamp DESC LIMIT 1");
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getSystemAlerts() {
        $stmt = $this->pdo->prepare("SELECT * FROM system_alerts ORDER BY alert_time DESC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

$dashboardController = new DashboardController($pdo);
$sensorData = $dashboardController->getSensorData();
$systemAlerts = $dashboardController->getSystemAlerts();
?>
