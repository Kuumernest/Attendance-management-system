<?php

class Attendance {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getOverallStats() {
        $stmt = $this->pdo->query('SELECT COUNT(*) as total, SUM(status = "present") as present FROM attendance');
        return $stmt->fetch();
    }

    public function getByStudent($student_id) {
        $stmt = $this->pdo->prepare('SELECT * FROM attendance WHERE student_id = ?');
        $stmt->execute([$student_id]);
        return $stmt->fetchAll();
    }

    public function mark($student_id, $date, $status) {
        $stmt = $this->pdo->prepare('INSERT INTO attendance (student_id, date, status) VALUES (?, ?, ?)');
        $stmt->execute([$student_id, $date, $status]);
    }
}