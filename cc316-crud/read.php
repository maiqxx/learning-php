<?php
include 'db_connection.php';
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

    <form method="POST" action="search.php">
<div class="container">
<button class="btn btn-primary my-5"><a href="create.php" class="text-light">Add Contact</a></button>
    <input type="text" placeholder="Search name or contact number..." style="width:350px; height:36px; " name="txtSearch"> 
    <button class="btn btn-primary"><a href="search.php" class="text-light">Search</a></button>
</form>

    <table class="table table-striped table-dark">
  <thead>
    <tr>
      <th scope="col">Id</th>
      <th scope="col">Name</th>
      <th scope="col">Address</th>
      <th scope="col">Contact Number</th>
      <th scope="col">Operations</th>
    </tr>
  </thead>
  <tbody>

  <?php
  $sql = "Select * from `contact`";
  $result = mysqli_query($conn, $sql);

  if($result){
     while($row = mysqli_fetch_assoc($result)) {
          $id = $row['id'];
          $name = $row['name'];
          $address = $row['address'];
          $contactNumber = $row['contactNumber'];

          echo '<tr>
          <th scope="row">'.$id.'</th>
          <td>'.$name.'</td>
          <td>'.$address.'</td>
          <td>'.$contactNumber.'</td>

          <td>
          <button class="btn btn-primary"><a href="update.php?updateid='.$id.'" class="text-light">Update</a></button>
          <button class="btn btn-danger"><a href="delete.php?deleteid='.$id.'" class="text-light">Delete</a></button>
   
        </tr> ';

     } 
  }
    
  ?>

    
  </tbody>
</table>

</div>

</body>
</html>