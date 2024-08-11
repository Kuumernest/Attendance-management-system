<?php
require 'config/database.php';

try {
    $stmt = $pdo->query('SELECT * FROM users');
    $users = $stmt->fetchAll();
    echo '<pre>', print_r($users, true), '</pre>';
} catch (\PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}
?>