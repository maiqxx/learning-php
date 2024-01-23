<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "student";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if(!$conn){
    die("Connection failed: " . mysqli_connect_error());
}
//echo "Connection established: " . mysqli_get_host_info($conn);

?>