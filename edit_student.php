<?php
require 'header.php';
session_start();
require_once 'config/database.php';
require_once 'models/Student.php';

$studentModel = new Student($pdo);

if (isset($_POST['id'])){
    $studentId = $__POST['id'];
    $student = $studentModel->fetchStudentById($studentId);
    if ($student){
        $name =  $student['name'];
        $email = $student['email'];
    }
    else{
        echo "Student not found.";
        exit();
    }
}
    else{
        echo "No student ID provided.";
        exit();
    }


// Fetch the student details based on ID
$id = $_POST['id'];
$student_id = $_POST['id'];
function fetchStudentById($id){
        $stmt = $this->pdo->prepare("SELECT * FROM students WHERE id = :id");
        $stmt->execute(['id'=> $id]);
        return
        $stmt->fetch(PDO::FETCH_ASSOC);
    }
$student = fetchStudentById($id);
$batches = fetchAllBatches();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_student'])) {
    $name = $_POST['name'];
    $batch_id = $_POST['batch_id'];

    updateStudent($student_id, $name, $batch_id);
    header('Location: students.php');
    exit();
}
?>

<h1>Edit Student</h1>
<form method="POST" action="update_student.php">

     <input type="hidden" name= "id" value= "<?php echo htmlspecialchars($id); ?>" required>
    <label for="name">Name: </label>
    <input type="text" name= "name" value="<?php echo htmlspecialchars($name); ?>" required> 

    <label for="name">Email: </label>
    <input type="email" name= "email" value="<?php echo htmlspecialchars($email); ?>" required>
        <?php foreach ($batches as $batch): ?>
            <option value="<?= $batch['id'] ?>" <?= $batch['id'] == $student['batch_id'] ? 'selected' : '' ?>><?= $batch['name'] ?></option>
        <?php endforeach; ?>
    </select>

    <button type="submit" name="edit_student">Update Student</button>
</form>
</body>
</html>

<?php require 'footer.php'; ?>




