<?php
$servername = "localhost";
$database = "cc70981_cafetery";
$username = "cc70981_cafetery";
$password = "tf5mFLZ4";

$conn = mysqli_connect($servername, $username, $password, $database);
// Проверяем соединение
if (!$conn) {
    die("Ошибка соединения: " . mysqli_connect_error());
}


