<?php
session_start();
include 'header.php';
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}



echo '<h2>Dashboard</h2>';

if ($_SESSION['role'] == 'admin') {
    // Admin dashboard
    echo '<p>Welcome, ' . $_SESSION['username'] . ' (Admin)</p>';
    
    // Display overall attendance statistics
    $totalStudents = $studentController->getTotalStudents();
    $attendanceStats = $attendanceController->getOverallAttendanceStats();
    $attendancePercentage = $attendanceStats['total'] > 0 ? ($attendanceStats['present'] / $attendanceStats['total']) * 100 : 0;

    echo '<div class="dashboard-section">';
    echo '<h3>Overall Attendance Statistics</h3>';
    echo '<p>Total Students: ' . $totalStudents . '</p>';
    echo '<p>Overall Attendance Percentage: ' . round($attendancePercentage, 2) . '%</p>';
    echo '</div>';

    // Quick actions
    echo '<div class="dashboard-section">';
    echo '<h3>Quick Actions</h3>';
    echo '<a href="attendance.php" class="btn">Mark Attendance</a>';
    echo '<a href="students.php" class="btn">Manage Students</a>';
    echo '</div>';
} elseif ($_SESSION['role'] == 'student') {
    // Student dashboard
    echo '<p>Welcome, ' . $_SESSION['username'] . ' (Student)</p>';

    // Display student attendance summary
    $studentAttendanceStats = $attendanceController->getByStudent($_SESSION['user_id']);
    $studentTotal = count($studentAttendanceStats);
    $studentPresent = count(array_filter($studentAttendanceStats, function($record) {
        return $record['status'] == 'present';
    }));
    $studentAttendancePercentage = $studentTotal > 0 ? ($studentPresent / $studentTotal) * 100 : 0;

    echo '<div class="dashboard-section">';
    echo '<h3>Your Attendance Summary</h3>';
    echo '<p>Your Attendance Percentage: ' . round($studentAttendancePercentage, 2) . '%</p>';
    echo '</div>';

    // Quick links
    echo '<div class="dashboard-section">';
    echo '<h3>Quick Links</h3>';
    echo '<a href="attendance.php" class="btn">View Attendance</a>';
    echo '<a href="settings.php" class="btn">Update Profile</a>';
    echo '</div>';
} else {
    echo '<p>You do not have access to this page.</p>';
}

echo "Welcome, " . $_SESSION['username'];


require_once './config/database.php';
require_once './controllers/AttendanceController.php';
require_once './controllers/StudentController.php';

$attendanceController = new AttendanceController($pdo);
$studentController = new StudentController($pdo);

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: ./login.php');
    exit();
}



include 'footer.php';
?>
<a href="logout.php">Logout</a>