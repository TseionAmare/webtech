<?php
// src/controllers/ScheduleController.php
require_once __DIR__ . '/../../config/connection.php';

class ScheduleController {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getSchedules() {
        $stmt = $this->pdo->prepare("SELECT * FROM schedules ORDER BY task_date, task_time");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addSchedule($taskType, $taskDate, $taskTime, $description) {
        $stmt = $this->pdo->prepare("INSERT INTO schedules (task_type, task_date, task_time, description) VALUES (?, ?, ?, ?)");
        $stmt->execute([$taskType, $taskDate, $taskTime, $description]);
    }

    public function deleteSchedule($id) {
        $stmt = $this->pdo->prepare("DELETE FROM schedules WHERE id = ?");
        $stmt->execute([$id]);
    }
}
?>
