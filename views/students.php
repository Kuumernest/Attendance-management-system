<?php
// views/students.php
session_start();
require_once 'config/database.php';
require_once 'controllers/StudentController.php';
require_once 'controllers/BatchController.php';

$studentController = new StudentController($pdo);
$batchController = new BatchController($pdo);

// Check if the user is logged in and is an admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header('Location: ../login.php');
    exit();
}

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['add_student'])) {
        $name = $_POST['name'];
        $batch_id = $_POST['batch_id'];
        $profile_info = $_POST['profile_info'];
        $studentController->add($name, $batch_id, $profile_info);
    } elseif (isset($_POST['update_student'])) {
        $id = $_POST['id'];
        $name = $_POST['name'];
        $batch_id = $_POST['batch_id'];
        $profile_info = $_POST['profile_info'];
        $studentController->update($id, $name, $batch_id, $profile_info);
    } elseif (isset($_POST['delete_student'])) {
        $id = $_POST['id'];
        $studentController->delete($id);
    }
}

// Fetch students and batches
$students = $studentController->getAll();
$batches = $batchController->getAll();

include 'header.php';
?>

<h2>Manage Students</h2>

<!-- Add Student Form -->
<div class="form-container">
    <h3>Add Student</h3>
    <form method="post" action="students.php">
        <input type="hidden" name="add_student" value="1">
        <label for="name">Name:</label>
        <input type="text" name="name" id="name" required>
        <label for="batch_id">Batch:</label>
        <select name="batch_id" id="batch_id" required>
            <?php foreach ($batches as $batch): ?>
                <option value="<?= $batch['id'] ?>"><?= $batch['name'] ?></option>
            <?php endforeach; ?>
        </select>
        <label for="profile_info">Profile Info:</label>
        <textarea name="profile_info" id="profile_info"></textarea>
        <button type="submit">Add Student</button>
    </form>
</div>

<!-- Student List -->
<div class="student-list">
    <h3>Student List</h3>
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Batch</th>
                <th>Profile Info</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($students as $student): ?>
                <tr>
                    <td><?= $student['name'] ?></td>
                    <td><?= $student['batch_name'] ?></td>
                    <td><?= $student['profile_info'] ?></td>
                    <td>
                        <form method="post" action="students.php" style="display:inline;">
                            <input type="hidden" name="delete_student" value="1">
                            <input type="hidden" name="id" value="<?= $student['id'] ?>">
                            <button type="submit">Delete</button>
                        </form>
                        <button onclick="populateUpdateForm('<?= $student['id'] ?>', '<?= $student['name'] ?>', '<?= $student['batch_id'] ?>', '<?= $student['profile_info'] ?>')">Update</button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- Update Student Form -->
<div class="form-container" id="update-student-form" style="display:none;">
    <h3>Update Student</h3>
    <form method="post" action="students.php">
        <input type="hidden" name="update_student" value="1">
        <input type="hidden" name="id" id="update-id">
        <label for="update-name">Name:</label>
        <input type="text" name="name" id="update-name" required>
        <label for="update-batch_id">Batch:</label>
        <select name="batch_id" id="update-batch_id" required>
            <?php foreach ($batches as $batch): ?>
                <option value="<?= $batch['id'] ?>"><?= $batch['name'] ?></option>
            <?php endforeach; ?>
        </select>
        <label for="update-profile_info">Profile Info:</label>
        <textarea name="profile_info" id="update-profile_info"></textarea>
        <button type="submit">Update Student</button>
    </form>
</div>

<script>
function populateUpdateForm(id, name, batch_id, profile_info) {
    document.getElementById('update-id').value = id;
    document.getElementById('update-name').value = name;
    document.getElementById('update-batch_id').value = batch_id;
    document.getElementById('update-profile_info').value = profile_info;
    document.getElementById('update-student-form').style.display = 'block';
}
</script>

<?php include 'footer.php'; ?>