<?php
$servername = "localhost";
$username = "root";
$password = "1234";
$dbname = "registerUser";

// Создаем соединение
$conn = new mysqli($servername, $username, $password, $dbname);

// Проверяем соединение
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
