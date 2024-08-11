<?php
require_once './models/Attendance.php';

class AttendanceController {
    private $attendance;

    public function __construct($pdo) {
        $this->attendance = new Attendance($pdo);
    }

    public function getOverallAttendanceStats() {
        return $this->attendance->getOverallStats();
    }

    public function getByStudent($student_id) {
        return $this->attendance->getByStudent($student_id);
    }

    public function mark($student_id, $date, $status) {
        $this->attendance->mark($student_id, $date, $status);
    }
}