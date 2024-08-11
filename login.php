
<?php 
error_reporting(0);
session_start();
include 'header.php';
require_once 'config/database.php';
require_once 'controllers/AuthController.php';

$auth = new AuthController($pdo);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['role'];
    $user = $auth->login($username, $password);
    if ($user) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];

        if ($role=="admin");
        header('Location: dashboard.php');
    } else {
        echo 'Invalid username or password';
    }  
}



 ?>
<form method="post" action="login.php">
    <label for="username">Username:</label>
    <input type="text" name="username" id="username" required>
    <label for="password">Password:</label>
    <input type="password" name="password" id="password" required>
    <button type="submit">Login</button>
</form>
  <p>Don't have an account? <a href="register.php">Register here</a></p>
<?php include 'footer.php'; ?>





