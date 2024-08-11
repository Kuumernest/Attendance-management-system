<?php
session_start();
require 'models/Student.php';
if ($_SERVER['REQUEST_METHOD']==='POST'){
    $id = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];

    $studentModel = new Student();
    $studentModel = updateStudent($id, $name, $email);

    header('Location: students.php');
    exit();
}