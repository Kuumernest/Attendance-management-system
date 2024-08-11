<?php
require_once 'config/database.php';
require_once 'models/Student.php';
require_once 'models/Batch.php';

$studentModel = new Student($pdo);
$batchModel = new Batch($pdo);

if ($_SERVER['REQUEST_METHOD'] =='POST'){
    $studentId = $_POST['student_id'];
    $batchId = $_POST['batch_id'];
    $studentModel->addStudentToBatch($studentId, $batchId);
    header("Location: students.php");
    exit;
}

if (! function_exists('fetchAllStudents')) {
    function fetchAllStudents(){
    global $pdo;
    $stmt = $pdo->query("SELECT * FROM students");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

$students = $studentModel->fetchAllStudents();
$batches = $batchModel->fetchAllBatches();

class StudentController {
    private $student;

    public function __construct($pdo) {
        $this->student = new Student($pdo);
    }

    public function getTotalStudents() {
        return $this->student->getTotal();
    }

    public function add($name, $batch_id, $profile_info) {
        $this->student->add($name, $batch_id, $profile_info);
    }

    public function update($id, $name, $batch_id, $profile_info) {
        $this->student->update($id, $name, $batch_id, $profile_info);
    }

    public function delete($id) {
        $this->student->delete($id);
    }

    public function getAll() {
        return $this->student->getAll();
    }

    public function getByBatch($batch_id) {
        return $this->student->getByBatch($batch_id);
    }
}
?>

