<?php
session_start();
require 'header.php';
require 'config/database.php';
require 'models/Student.php';

if (!isset($_SESSION['username'])){
    header("Location:login.php");
}


$conn = mysqli_connect("localhost", "root", "", "eschosys");
if(!$conn){
    die("Connection Failed: " . mysqli_connect_error());
}

// Handle form submission for adding a new student
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_student'])) {
    $name = $_POST['name'];
    $batch_id = $_POST['batch_id'];

    $stmt = $pdo->prepare("INSERT INTO students (name, batch_id) VALUES (:name, :batch_id)");
    $stmt->execute(['name' => $name, 'batch_id' => $batch_id]);


    

    header('Location: students.php');
    exit();
}

// Handle student deletion
if (isset($_POST['delete_id'])) {
    $delete_id = $_POST['delete_id'];

    $stmt = $pdo->prepare("DELETE FROM students WHERE id = :id");
    $stmt->execute(['id' => $delete_id]);

    header('Location: students.php');
    exit();
}

// Fetch all students and batches
$students = fetchAllStudents();

function fetchAllBatches(){
    global $pdo;
    $stmt = $pdo->query("SELECT * FROM batches" );
    return
    $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>


<h2>Student Management</h2>

<!-- Form to add a new student -->
<form method="POST" action="">
    <h3>Add New Student</h3>
    <label for="name">Name:</label>
    <input type="text" name="name" id="name" required>
    
    <label for="batch_id">Batch:</label>
    <select name="batch_id" id="batch_id" required>
        <?php
        $sql = "SELECT id, name FROM batches";
        $result = mysqli_query($conn, $sql);
        While ($row = mysqli_fetch_assoc($result)) {
            echo " <option value='" . $row['id'] . "'>" . $row['name'] . "</option>";
        }
        ?>
        </selct>
        <?php foreach ($batches as $batch): ?>
            <option value="<?= $batch['id'] ?>"><?= $batch['name'] ?></option>
        <?php endforeach; ?>
    </select>
    
    <button type="submit" name="add_student">Add Student</button>
</form>

<!-- List of all students -->
<h3>All Students</h3>
<table>
    <thead>
        <tr>
            <th>Name</th>
            <th>Batch</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($students as $student): ?>
            <tr>
                <td><?= $student['name'] ?></td>
                <td><?= $student['batch_id'] ?></td>
                <td>
                    <!-- Add links for editing and deleting student profiles -->
                    <a href="edit_student.php? id=<?= $student['id'] ?>">Edit</a>
                    <a href="delete_student.php?student_id=<?= $student['id'] ?>" onclick="return confirm('Are you sure you want to delete this student?')">Delete</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php require 'views/footer.php'; ?>