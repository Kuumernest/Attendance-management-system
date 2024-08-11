<?php
require './config/database.php';

class Student {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getTotal() {
        $stmt = $this->pdo->query('SELECT COUNT(*) FROM students');
        return $stmt->fetchColumn();
    }

    public function add($name, $batch_id, $profile_info) {
        $stmt = $this->pdo->prepare('INSERT INTO students (name, batch_id, profile_info) VALUES (?, ?, ?)');
        $stmt->execute([$name, $batch_id, $profile_info]);
    }

    public function UpdateStudents($id, $name, $batch_id, $profile_info) {
        $stmt = $this->pdo->prepare('UPDATE students SET name = :name, email= :email, batch_id = :batch_id, profile_info = :profile_info WHERE id = :id');
        $stmt->execute(['id'=> $id, 'name'=>$name, 'email'=>$email, 'batch_id'=>$batch_id, 'profile_info'=>$profile_info]);
    }

    public function delete($id) {
        $stmt = $this->pdo->prepare('DELETE FROM students WHERE id = ?');
        $stmt->execute([$id]);
    }

    public function getAll() {
        $stmt = $this->pdo->query('SELECT students.*, batches.name AS batch_name FROM students JOIN batches ON students.batch_id = batches.id');
        return $stmt->fetchAll();
    }

    public function getByBatch($batch_id) {
        $stmt = $this->pdo->prepare('SELECT * FROM students WHERE batch_id = ?');
        $stmt->execute([$batch_id]);
        return $stmt->fetchAll();
    }
    public function fetchStudentById($id){
        $stmt = $this->pdo->prepare("SELECT * FROM students WHERE id = :id");
        $stmt->execute(['id'=> $id]);
        return
        $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function fetchAllStudents(){
    global $pdo;
    $stmt = $pdo->query("SELECT * FROM students");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}



// Function to fetch all students
if (! function_exists('fetchAllStudents')) {
    function fetchAllStudents(){
    global $pdo;
    $stmt = $pdo->query("SELECT * FROM students");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

// Function to fetch all attendance records
function fetchAllAttendanceRecords() {
    global $pdo;
    $query = "SELECT attendance.id, students.name as student_name, attendance.date, attendance.status 
              FROM attendance 
              JOIN students ON attendance.student_id = students.id";
              
    // Apply filters if any
    if (isset($_GET['filter_date']) && $_GET['filter_date'] != '') {
        $query .= " WHERE date = :filter_date";
    }
    
    if (isset($_GET['filter_status']) && $_GET['filter_status'] != '') {
        $query .= " AND status = :filter_status";
    }

    $stmt = $pdo->prepare($query);
    if (isset($_GET['filter_date']) && $_GET['filter_date'] != '') {
        $stmt->bindParam(':filter_date', $_GET['filter_date']);
    }
    
    if (isset($_GET['filter_status']) && $_GET['filter_status'] != '') {
        $stmt->bindParam(':filter_status', $_GET['filter_status']);
    }
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Handle form submission for marking attendance
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['mark_attendance'])) {
    $student_id = $_POST['student_id'];
    $date = $_POST['date'];
    $status = $_POST['status'];

    $stmt = $pdo->prepare("INSERT INTO attendance (student_id, date, status) VALUES (:student_id, :date, :status)");
    $stmt->execute(['student_id' => $student_id, 'date' => $date, 'status' => $status]);

    header('Location: views/attendance.php');
    exit();
}
?>



