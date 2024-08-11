<?php
session_start();
require_once 'config/database.php';

// Redirect to dashboard if already logged in
if (isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Include header
include 'header.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Attendance Management System</title>
</head>
<body>
    <div class="container">
        <h1>Welcome to the Attendance Management System</h1>
        <p>Please login or register to continue.</p>
        <a href="login.php" class="btn">Login</a>
        <a href="register.php" class="btn">Register</a>
    </div>
</body>
</html>

<?php
// Include footer
include 'views/footer.php';
?>