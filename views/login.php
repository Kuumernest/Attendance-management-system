<?php
include 'header.php';
 ?>
<form method="post" action="login.php">
    <label for="username">Username:</label>
    <input type="text" name="username" id="username" required>
    <label for="password">Password:</label>
    <input type="password" name="password" id="password" required>
    <button type="submit">Login</button>
</form>
<?php include 'footer.php'; ?>


