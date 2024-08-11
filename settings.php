<?php
session_start();
require 'header.php';
require 'config/database.php';
require 'models/User.php';



if (!isset($_SESSION['username'])){
    header("Location:login.php");
}
// Fetch the current user information
$user = fetchUserById($_SESSION['user_id']);

// Initialize error messages array
$id = '';
$name = '';
$email = '';
$errors = [];

// Handle form submission for updating profile
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_profile'])) {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);

    // Validate name
    if (empty($name)) {
        $errors['name'] = 'Name is required.';
    }

    // Validate email
    if (empty($email)) {
        $errors['email'] = 'Email is required.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Invalid email format.';
    }

    // If no errors, update the profile
    if (empty($errors)) {
        $stmt = $pdo->prepare("UPDATE users SET name = :name, email = :email WHERE id = :id");
        $stmt->execute(['name' => $name, 'email' => $email, 'id' => $_SESSION['user_id']]);

        header('Location: settings.php');
        exit();
    }
}

// Handle form submission for changing password
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['change_password'])) {
    $current_password = trim($_POST['current_password']);
    $new_password = trim($_POST['new_password']);
    $confirm_password = trim($_POST['confirm_password']);

    // Validate passwords
    if (empty($current_password)) {
        $errors['current_password'] = 'Current password is required.';
    }
    if (empty($new_password)) {
        $errors['new_password'] = 'New password is required.';
    }
    if ($new_password !== $confirm_password) {
        $errors['confirm_password'] = 'Passwords do not match.';
    }

    // Check current password and update if valid
    if (empty($errors) && password_verify($current_password, $user['password'])) {
        $hashed_password = password_hash($new_password, PASSWORD_BCRYPT);

        $stmt = $pdo->prepare("UPDATE users SET password = :password WHERE id = :id");
        $stmt->execute(['password' => $hashed_password, 'id' => $_SESSION['user_id']]);

        echo "Password changed successfully!";
    } else {
        $errors['current_password'] = 'Invalid current password or passwords do not match.';
    }
}
?>



<h2>Settings</h2>

<div class="settings-container">
    <!-- Form to update profile information -->
    <form method="POST" action="" class="settings-form">
        <h3>Update Profile</h3>
        <label for="name">Name:</label>
        <input type="text" name="name" id="name" value="<?= htmlspecialchars($user['name']) ?>" required>
        <?php if (isset($errors['name'])): ?>
            <span class="error"><?= htmlspecialchars($errors['name']) ?></span>
        <?php endif; ?>

        <label for="email">Email:</label>
        <input type="email" name="email" id="email" value="<?= htmlspecialchars($user['email']) ?>" required>
        <?php if (isset($errors['email'])): ?>
            <span class="error"><?= htmlspecialchars($errors['email']) ?></span>
        <?php endif; ?>

        <button type="submit" name="update_profile">Update Profile</button>
    </form>

    <!-- Form to change password -->
    <form method="POST" action="" class="settings-form">
        <h3>Change Password</h3>
        <label for="current_password">Current Password:</label>
        <input type="password" name="current_password" id="current_password" required>
        <?php if (isset($errors['current_password'])): ?>
            <span class="error"><?= htmlspecialchars($errors['current_password']) ?></span>
        <?php endif; ?>

        <label for="new_password">New Password:</label>
        <input type="password" name="new_password" id="new_password" required>
        <?php if (isset($errors['new_password'])): ?>
            <span class="error"><?= htmlspecialchars($errors['new_password']) ?></span>
        <?php endif; ?>

        <label for="confirm_password">Confirm Password:</label>
        <input type="password" name="confirm_password" id="confirm_password" required>
        <?php if (isset($errors['confirm_password'])): ?>
            <span class="error"><?= htmlspecialchars($errors['confirm_password']) ?></span>
        <?php endif; ?>

        <button type="submit" name="change_password">Change Password</button>
    </form>
</div>

<?php require 'views/footer.php'; ?>