Views/settings.php

<?php
require 'header.php';

// Fetch the user details based on session user_id
$user_id = $_SESSION['user_id'];
$user = fetchUserById($user_id);

// Handle profile update form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_profile'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];

    updateUserProfile($user_id, $name, $email);
    $user = fetchUserById($user_id); // Refresh user data
    echo "<p>Profile updated successfully!</p>";
}

// Handle password change form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['change_password'])) {
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    if ($new_password === $confirm_password && verifyPassword($user_id, $current_password)) {
        changeUserPassword($user_id, $new_password);
        echo "<p>Password changed successfully!</p>";
    } else {
        echo "<p>Failed to change password. Please check your input.</p>";
    }
}
?>

<h2>Settings</h2>
<p>Update your profile information and change your password.</p>

<!-- Profile Information Form -->
<form method="POST" action="">
    <h3>Profile Information</h3>
    <label for="name">Name:</label>
    <input type="text" id="name" name="name" value="<?= $user['name'] ?>" required>

    <label for="email">Email:</label>
    <input type="email" id="email" name="email" value="<?= $user['email'] ?>" required>

    <button type="submit" name="update_profile">Update Profile</button>
</form>

<!-- Password Change Form -->
<form method="POST" action="">
    <h3>Change Password</h3>
    <label for="current_password">Current Password:</label>
    <input type="password" id="current_password" name="current_password" required>

    <label for="new_password">New Password:</label>
    <input type="password" id="new_password" name="new_password" required>

    <label for="confirm_password">Confirm New Password:</label>
    <input type="password" id="confirm_password" name="confirm_password" required>

    <button type="submit" name="change_password">Change Password</button>
</form>

<?php require 'footer.php'; ?>