<?php
$host = 'localhost';
$db = 'budget_tracker';
$user = 'root';
$pass = 'Sarf6918#';

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
