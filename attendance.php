<?php
session_start();
require 'header.php';
require 'config/database.php';
require 'models/Student.php';

if (!isset($_SESSION['username'])){
    header("Location:login.php");
}

// Fetch all students
$students = fetchAllStudents();



// Check for form submission to mark attendance
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['mark_attendance'])) {
    $student_id = $_POST['student_id'];
    $date = $_POST['date'];
    $status = $_POST['status'];

    // Insert attendance record into the database
    $stmt = $pdo->prepare("INSERT INTO attendance (student_id, date, status) VALUES (:student_id, :date, :status)");
    $stmt->execute(['student_id' => $student_id, 'date' => $date, 'status' => $status]);

    echo "Attendance marked successfully!";
}
?>

<h2>Mark Attendance</h2>

<form method="POST" action="">
    <label for="student_id">Student:</label>
    <select name="student_id" id="student_id" required>
        <?php foreach ($students as $student): ?>
            <option value="<?= $student['id'] ?>"><?= $student['name'] ?></option>
        <?php endforeach; ?>
    </select>

    <label for="date">Date:</label>
    <input type="date" name="date" id="date" required>

    <label for="status">Status:</label>
    <select name="status" id="status" required>
        <option value="present">Present</option>
        <option value="absent">Absent</option>
    </select>

    <button type="submit" name="mark_attendance">Mark Attendance</button>
</form>

<?php require 'footer.php'; ?>