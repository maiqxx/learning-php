<?php
include 'db_connection.php';
if(isset($_GET['deleteid'])){
    $id = $_GET['deleteid'];

    $sql = "delete from `contact` where id=$id";
    $result = mysqli_query($conn,$sql);
    if($result){
        header('location:read.php');
    }else{
        die(mysqli_error($conn));
    }
}
?>