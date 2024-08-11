
<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "eschosys";
$charset = 'utf8mb4';

$conn = mysqli_connect("$servername", "$username", "$password", "$dbname");

if($_GET['student_id']){
    $student_id = $_GET['student_id'];
    $sql ="DELETE FROM students WHERE id = 'student_id' ";
    $result = mysqli_query($conn,$sql);

    if($result){
        header("Location: students.php");
    }
}
if($_GET['user_id']){
    $user_id = $_GET['user_id'];
    $sql ="DELETE FROM user WHERE id = 'user_id' ";
}