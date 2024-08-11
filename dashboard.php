

<?php
session_start();
require_once './config/database.php';
require_once './controllers/AttendanceController.php';



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance Management Dashboard</title>
    <link rel="stylesheet" href="header.css">


    <?php
 
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['mark_attendance'])) {
    $student_id = $_POST['student_id'];
    $date = $_POST['date'];
   $status = $_POST['status'];
    }
 require_once './controllers/studentController.php';
$attendanceController = new AttendanceController($pdo);
$studentController = new StudentController($pdo);

// Check if the user is logged in

    if ($_SESSION['role'] == 'admin') {
    // Admin dashboard
       echo '<p>Welcome, ' . $_SESSION['username'] . ' (Admin)</p>';
    }

     elseif ($_SESSION['role'] == 'student') {
    // Student dashboard
    header("Location: ./views/dashboard.php");
     }
     else{
        echo "Invalid username or password";
        header("Location: login.php");
     }

?>

</head>
<body>
    <div class="container">
        <header>
            <div class="logo">
                <img src="logo.jpg" alt="Company Logo">
            </div>
            <h1>Dashboard</h1>
            <div class="user-profile">
                <img src="user-profile.jpg" alt="user-profile">
            </div>
        </header>

        <nav class="sidebar">
            <ul>
                <li><a href="#">Dashboard Overview</a></li>
                <li><a href="attendance.php">Mark Attendance</a></li>
                <li><a href="#">View Attendance Reports</a></li>
                <li><a href="students.php">Student Management</a></li>
                <li><a href="attendance.php">Attendance Management</a></li>
                <li><a href="settings.php">Settings</a></li>
                <li><a href="login.php">Login</a></li>
                <li><a href="logout.php">Logout</a> </li>
            </ul>
        </nav>

        <main>
            <section class="stats-overview">
                <div class="stat-card">
                    <h3>Total Students</h3>
                    <p>500</p>
                </div>
                <div class="stat-card">
                    <h3>Total Batches</h3>
                    <p>04</p>
                </div>
                <div class="stat-card">
                    <h3>Overall Attendance Rate</h3>
                    <p>95%</p>
                </div>
                <div class="stat-card">
                    <h3>Today's Attendance</h3>
                    <p>480</p>
                </div>
                <div class="stat-card">
                    <h3>Absences Today</h3>
                    <p>20</p>
                </div>
                <div class="stat-card">
                    <h3>Late Arrivals Today</h3>
                    <p>5</p>
                </div>
            </section>

            <section class="quick-actions">
                <a href="attendance.php"> <button class="action-button">Mark Attendance</button></a>
                <a href="edit_student.php"> <button class="action-button">Edit Student</button></a>
                <a href="attendance.php"> <button class="action-button">Generate Report</button></a>
               
            </section>

            <section class="recent-activity">
                <h2>Recent Attendance Activity</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Batch</th>
                            <th>Total Present</th>
                            <th>Total Absent</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>2024-07-31</td>
                            <td>Batch 1</td>
                            <td>30</td>
                            <td>2</td>
                        </tr>
                        <tr>
                            <td>2024-07-30</td>
                            <td>Batch 2</td>
                            <td>25</td>
                            <td>3</td>
                        </tr>
                        <tr>
                            <td>2024-07-31</td>
                            <td>Batch 3</td>
                            <td>30</td>
                            <td>2</td>
                        </tr>
                        <tr>
                            <td>2024-07-29</td>
                            <td>Batch 4</td>
                            <td>30</td>
                            <td>2</td>
                        </tr>
                        <!-- Additional rows
                         can be added here -->
                    </tbody>
                </table>
            </section>
        </main>

        <footer>
            <p>&copy; 2024 Eschosys Attendance System. All rights reserved.</p>
        </footer>
    </div>
</body>
</html>

<?php include 'footer.php';
?>