<?php
include 'db_connection.php';
$id = $_GET['updateid'];
$sql = "select * from `contact` where id=$id";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$name = $row['name'];
$address = $row['address'];
$contactNumber = $row['contactNumber'];



if (isset($_POST['submit'])){
    $name = $_POST['name'];
    $address=$_POST['address'];
    $contactNumber =$_POST['contactNumber'];

    $sql = "update `contact` set id=$id, name='$name', address='$address', contactNumber='$contactNumber'
    where id=$id";
    $result = mysqli_query($conn,$sql);

    if($result){
       header('location:read.php');
    }else{
        die(mysqli_error($conn));
    }
} 

?>


<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">

    <title>CC316 Final Activities</title>
</head>

<body>
    <nav class="navbar navbar-light justify-content-center fs-3 mb-5" 
        style="background-color: #b7d5d4; font-size: 25px; font-weight: bold;  ">
        CC316 Final Activities
    </nav>      

    <div class="container my-5">
        <form method="post">
            <div class="form-group">
                <label>Name</label>
                <input type="text" class="form-control" placeholder="Name" name="name" autocomplete="off"
                value=<?php echo $name;?>>
            </div>

            <div class="form-group">
                <label>Address</label>
                <input type="text" class="form-control" placeholder="Address" name="address" autocomplete="off"
                value=<?php echo $address;?>>
            </div>

            <div class="form-group">
                <label>Contact Number</label>
                <input type="text" class="form-control" placeholder="Contact Number" name="contactNumber" autocomplete="off"
                value=<?php echo $contactNumber;?>>
            </div>
           

            <button type="submit" class="btn btn-primary" name="submit">Update</button>
        </form>

    </div>


</body>
</html>