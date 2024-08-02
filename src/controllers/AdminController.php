<?php
// src/controllers/AdminController.php
require_once __DIR__ . '/../../config/connection.php';

class AdminController {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // CRUD operations for Greenhouses
    public function addGreenhouse($name, $location) {
        $stmt = $this->pdo->prepare("INSERT INTO greenhouses (name, location) VALUES (?, ?)");
        $stmt->execute([$name, $location]);
    }

    // CRUD operations for Crops
    public function addCrop($greenhouseId, $plantId, $status) {
        $stmt = $this->pdo->prepare("INSERT INTO crops (greenhouse_id, plant_id, status) VALUES (?, ?, ?)");
        $stmt->execute([$greenhouseId, $plantId, $status]);
    }

    // CRUD operations for Resources
    public function addResource($greenhouseId, $type, $quantity, $unit, $lastReplenished) {
        $stmt = $this->pdo->prepare("INSERT INTO resources (greenhouse_id, type, quantity, unit, last_replenished) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$greenhouseId, $type, $quantity, $unit, $lastReplenished]);
    }

    // CRUD operations for Watering Schedule
    public function addWateringSchedule($greenhouseId, $scheduleTime, $duration, $frequency) {
        $stmt = $this->pdo->prepare("INSERT INTO watering_schedule (greenhouse_id, schedule_time, duration, frequency) VALUES (?, ?, ?, ?)");
        $stmt->execute([$greenhouseId, $scheduleTime, $duration, $frequency]);
    }
}
?>
