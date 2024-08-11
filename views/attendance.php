
<?php
session_start();
require '../header.php';
require_once '../config/database.php';
require_once '../controllers/AttendanceController.php';
require_once '../controllers/StudentController.php';

$attendanceController = new AttendanceController($pdo);
$studentController = new StudentController($pdo);

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: ./login.php');
    exit();
}

// Check user role
if ($_SESSION['role'] == 'admin') {
    // Admin view: Mark attendance
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['student_id'], $_POST['status'])) {
        $student_id = $_POST['student_id'];
        $status = $_POST['status'];
        $date = date('Y-m-d'); // Today's date
        $attendanceController->mark($student_id, $date, $status);
    }

    // Get all students
    $batch = $_POST['batch_id'];
    $students = $studentController->getByBatch($_SESSION['batch_id']); // Assuming batch_id is stored in session for simplicity

    echo '<h2>Mark Attendance</h2>';
    echo '<form method="post" action="attendance.php">';
    echo '<label for="student_id">Student:</label>';
    echo '<select name="student_id" id="student_id" required>';
    foreach ($students as $student) {
        echo '<option value="' . $student['id'] . '">' . $student['name'] . '</option>';
    }
    echo '</select>';
    echo '<label for="status">Status:</label>';
    echo '<select name="status" id="status" required>';
    echo '<option value="present">Present</option>';
    echo '<option value="absent">Absent</option>';
    echo '</select>';
    echo '<button type="submit">Mark Attendance</button>';
    echo '</form>';
} elseif ($_SESSION['role'] == 'student') {
    // Student view: View attendance
    $attendanceRecords = $attendanceController->getByStudent($_SESSION['user_id']);

    echo '<h2>Your Attendance Records</h2>';
    echo '<table>';
    echo '<tr><th>Date</th><th>Status</th></tr>';
    foreach ($attendanceRecords as $record) {
        echo '<tr>';
        echo '<td>' . $record['date'] . '</td>';
        echo '<td>' . $record['status'] . '</td>';
        echo '</tr>';
    }
    echo '</table>';
} else {
    echo '<p>You do not have access to this page.</p>';
}







// Fetch students and attendance records from the database
$students = fetchAllStudents();
$attendanceRecords = fetchAllAttendanceRecords();

?>

<h2>Attendance</h2>
<p>View and manage student attendance records.</p>

<!-- Attendance Form -->
<form method="POST" action="../attendance.php">
    <label for="student_id">Student ID:</label>
    <select id="student_id" name="student_id" required>
        <?php foreach ($students as $student): ?>
            <option value="<?= $student['id'] ?>"><?= $student['name'] ?></option>
        <?php endforeach; ?>
    </select>

    <label for="date">Date:</label>
    <input type="date" id="date" name="date" required>

    <label for="status">Status:</label>
    <select id="status" name="status" required>
        <option value="present">Present</option>
        <option value="absent">Absent</option>
    </select>

    <button type="submit" name="mark_attendance">Mark Attendance</button>
</form>

<!-- Search and Filter Options -->
<form method="GET" action="">
    <label for="search_student">Search Student:</label>
    <input type="text" id="search_student" name="search_student">

    <label for="filter_date">Filter by Date:</label>
    <input type="date" id="filter_date" name="filter_date">

    <label for="filter_status">Filter by Status:</label>
    <select id="filter_status" name="filter_status">
        <option value="">All</option>
        <option value="present">Present</option>
        <option value="absent">Absent</option>
    </select>

    <button type="submit" name="filter_attendance">Filter</button>
</form>

<!-- Attendance Table -->
<table>
    <thead>
        <tr>
            <th>Student Name</th>
            <th>Date</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($attendanceRecords as $record): ?>
            <tr>
                <td><?= $record['student_name'] ?></td>
                <td><?= $record['date'] ?></td>
                <td><?= $record['status'] ?></td>
                <td>
                    <a href="edit_attendance.php?id=<?= $record['id'] ?>">Edit</a>
                    <a href="delete_attendance.php?id=<?= $record['id'] ?>" onclick="return confirm('Are you sure you want to delete this record?')">Delete</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php require '../footer.php'; ?>