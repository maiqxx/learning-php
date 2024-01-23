<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "student";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$result = $conn->query("SELECT MAX(id) AS maxIdNum FROM studentinfo2");
$row = $result->fetch_assoc();
$nextIdNum = $row['maxIdNum'] + 1;

echo "IT-" . sprintf("%04d", $nextIdNum);

$conn->close();
?>
