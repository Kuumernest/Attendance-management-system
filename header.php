<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Attendance Management System</title>
    <style>
        body {
  font-family: Arial, sans-serif;
  margin: 0;
  padding: 0;
  background-color: yellow;
}

header {
  background-color: darkblue;
  color: #fff;
  padding: 10px 0;
  text-align: center;
  padding: 20px;
  font-size: 20px;
}
header a {
  color: white;
  margin: 30px;
}

header h1 {
  font-size: 35px;
}

.container {
  width: 90%;
  margin: 20px auto;
  padding: 20px;
  background-color: #fff;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
  text-align: center;
  margin-top: 100px;
}
.container p {
  font-size: 22px;
}

h2 {
  margin-top: 0;
}

form {
  margin-bottom: 20px;
}

form label {
  display: block;
  margin-bottom: 5px;
  font-size: 20px;
}

form input[type="text"],
form input[type="date"],
form input[type="password"],
form select {
  width: 60%;
  padding: 8px;
  margin-bottom: 10px;
  border: 1px solid #ccc;
  border-radius: 4px;
  height: 35px;
}

form button {
  padding: 10px 15px;
  background-color: blue;
  color: #fff;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  height: 35px;
}

form button:hover {
  background-color: #555;
}

table {
  width: 100%;
  border-collapse: collapse;
  margin-bottom: 20px;
}

table,
th,
td {
  border: 1px solid #ccc;
}

th,
td {
  padding: 10px;
  text-align: left;
}

th {
  background-color: #f4f4f4;
}

a {
  color: #333;
  text-decoration: none;
}

a:hover {
  text-decoration: underline;
}
.btn {
  font-size: 20px;
  margin: 20px;
}
footer {
  text-align: center;
  margin-top: 170px;
  font-size: 20px;

nav ul li {
    margin: 0 15px;
}

nav ul li a {
    color: #fff;
    text-decoration: none;
}

main {
    padding: 20px;
}

.settings-container {
    display: flex;
    flex-direction: column;
    align-items: center;
}

.settings-form {
    width: 100%;
    max-width: 400px;
    margin: 20px;
    padding: 20px;
    border: 1px solid #ccc;
    border-radius: 5px;
    background-color: #f9f9f9;
}

.settings-form h3 {
    margin-top: 0;
}

.settings-form label {
    display: block;
    margin: 10px 0 5px;
}

.settings-form input {
    width: 100%;
    padding: 10px;
    margin-bottom: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

.settings-form button {
    padding: 10px 20px;
    background-color: #333;
    color: #fff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

.settings-form button:hover {
    background-color: #555;
}

/* Responsive Design */
@media (max-width: 600px) {
    nav ul {
        flex-direction: column;
    }

    nav ul li {
        margin: 10px 0;
    }

    .settings-container {
        padding: 10px;
    }

    .settings-form {
        width: 100%;
    }
}
}
.error {
    color: red;
    font-size: 16px;
    margin-top: 5px;
}
a{
  color: blue;
}

    </style>

</head>
<body>
    <header>
        <h1>Attendance Management System</h1>
        <nav>
            <a href="./dashboard.php">Dashboard</a>
            <a href="./attendance.php">Attendance</a>
            <a href="./students.php">Students</a>
            <a href="./settings.php">Settings</a>
            <a href="./logout.php">Logout</a>
        </nav>
    </header>
    <div class="container">