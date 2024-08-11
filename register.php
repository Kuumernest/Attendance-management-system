<?php
session_start();
require 'header.php';
require_once 'config/database.php';
require_once 'controllers/AuthController.php';

$auth = new AuthController($pdo);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['role']; // Assuming role is being selected during registration
    $auth->register($username, $password, $role);

    

    header('Location: login.php');
    exit();
    echo "Registration successful.";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
</head>
<body>
    <div class="container">
        <h2>Register</h2>
        <form method="post" action="register.php">
            <label for="username">Username:</label>
            <input type="text" name="username" id="username" required>
            <label for="password">Password:</label>
            <input type="password" name="password" id="password" required>
            <label for="role">Role:</label>
            <select name="role" id="role">
                <option value="student">Student</option>
                <option value="admin">Admin</option>
            </select>
            <button type="submit">Register</button>
        </form>
       <p>Already have an account? <a href="login.php">Login here</a> </p>
    </div>
</body>
</html>

<?php include 'views/footer.php'; ?>