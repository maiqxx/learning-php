<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "student";

    $conn = mysqli_connect($servername, $username, $password, $dbname);

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // function isValidEmail($email)
    // {
    //     return filter_var($email, FILTER_VALIDATE_EMAIL);
    // }

    function calculateAge($birthdate)
    {
        $today = new DateTime();
        $dob = new DateTime($birthdate);
        $age = $today->diff($dob)->y;
        return $age;
    }

    if (isset($_POST['add'])) {
        $firstname = $_POST['firstname'];
        $middlename = $_POST['middlename'];
        $lastname = $_POST['lastname'];
        // $email = $_POST['email'];
        $birthdate = $_POST['birthdate'];
        $address = $_POST['address'];
        $password = $_POST['password'];
    
        // Check for duplicate entry
        // Modify the query where it will not accept a student info with existing firstname and lastname, but accepts it only if the middle name in student info is unique
        $sql = "SELECT * FROM studentinfo2 
            WHERE fname='$firstname' 
            AND lname='$lastname' AND mname='$middlename' " ;
        $res = mysqli_query($conn, $sql);
    
        if (mysqli_num_rows($res) > 0) {
            // Duplicate email found, handle accordingly
            $message = "Already added";
            echo "<script type='text/javascript'>alert('$message');</script>";
        } else {
            // Validate name fields
            if (!preg_match("/^[a-zA-Z\s]+$/", $firstname) || !preg_match("/^[a-zA-Z]+$/", $lastname)) {
                $message = "Invalid input for name fields. Only letters allowed.";
                echo "<script type='text/javascript'>alert('$message');</script>";
            } else {
                // Validate age
                $age = calculateAge($birthdate);
    
                if (!is_numeric($age)) {
                    $message = "Error calculating age.";
                    echo "<script type='text/javascript'>alert('$message');</script>";
                } else {
                    // No validation issues, proceed with insertion
                    // Retrieve the latest idNum from the database and increment it
                    $result = $conn->query("SELECT MAX(id) AS maxIdNum FROM studentinfo2");
                    $row = $result->fetch_assoc();
                    $nextIdNum = $row['maxIdNum'] + 1;
    
                    // Combine the string 'IT-000' with the incremented ID
                    $idNum = "IT-" . sprintf("%04d", $nextIdNum);
    
                    // Insert new student info into the database
                    $sql = "INSERT INTO studentinfo2 (idNum, fname, mname, lname, birthdate, age, address, password) VALUES ('$idNum', '$firstname', '$middlename', '$lastname', '$birthdate', '$age', '$address', '$password')";
    
                    if ($conn->query($sql) === TRUE) {
                        // Display success message
                        $message = "Student added successfully.";
                        echo "<script type='text/javascript'>alert('$message');</script>";
                        echo "<script>document.getElementById('nextIdNum').value = '$idNum';</script>";
                        echo "<script>window.location.reload();</script>";
                    } else {
                        // Display error if insertion fails
                        echo "Error: " . $sql . "<br>" . $conn->error;
                    }
                }
            }
        }
    }


    if (isset($_POST['update'])) {
        $id = $_POST['id'];
        $firstname = $_POST['firstname'];
        $middlename = $_POST['middlename'];
        $lastname = $_POST['lastname'];
        // $email = $_POST['email'];
        $birthdate = $_POST['birthdate'];
        $address = $_POST['address'];
        $password = $_POST['password'];

        if (!preg_match("/^[a-zA-Z\s]+$/", $firstname) || !preg_match("/^[a-zA-Z]+$/", $lastname)) {
            $message = "Invalid input for name fields. Only letters allowed.";
            echo "<script type='text/javascript'>alert('$message');</script>";
            header("Location: student1.php?error=Invalid input for name fields. Only letters allowed&id=$id");
            exit();
        } else {
            $age = calculateAge($birthdate);
            $sql = "UPDATE studentinfo2 SET fname='$firstname', mname='$middlename', lname='$lastname', birthdate='$birthdate', age='$age', address='$address', password='$password' WHERE id=$id";

            if ($conn->query($sql) === TRUE) {
                $message = "Student information updated successfully.";
                echo "<script type='text/javascript'>alert('$message');</script>";
                // header("Location: student1.php?success=Student information updated successfully&id=$id");
                // exit();
            } else {
                $message = "Error updating student info: " . $conn->error;
                echo "<script type='text/javascript'>alert('$message');</script>";
                header("Location: student1.php?error=Error updating student info&id=$id");
                exit();
            }
        }
    }


    if (isset($_GET['delete'])) {
        $id = $_GET['delete'];
        $sql = "DELETE FROM studentinfo2 WHERE id=$id";
        if ($conn->query($sql) === TRUE) {
            $message = "Student info deleted successfully";
            echo "<script type='text/javascript'>alert('$message');</script>";
            // header("Location: student1.php?success=Deleted a student successfully&$id");
            // exit();

        } else {
            $message = "Error deleting student info: " . $conn->error;
            echo "<script type='text/javascript'>showToast('$message', 'error');</script>";
            header("Location: student1.php?error=Error deleting student info&$id");
            exit();
        }
    }

    //the previous search
    // if (isset($_POST['search'])) {
    //     $searchAddress = $_POST['searchAddress'];
    //     $result = $conn->query("SELECT * FROM studentinfo2 WHERE address LIKE '%$searchAddress%'");

    //     // if no data, alert msg - No result
    // }

    if (isset($_POST['search'])) {
        $searchAddress = $_POST['searchAddress'];
        $searchCondition = "WHERE fname LIKE '%$searchAddress%'";
    } else {
        $searchCondition = "";
    }
    

    // Pagination settings
    $rowsPerPage = 10;
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $offset = ($page - 1) * $rowsPerPage;

    if (isset($_POST['showAll'])) {
    $result = $conn->query("SELECT * FROM studentinfo2");

    }

    // Fetch data with pagination
    $query = "SELECT * FROM studentinfo2 LIMIT $offset, $rowsPerPage";
    $result = $conn->query($query);

    // Pagination links
    $totalRowsQuery = "SELECT COUNT(id) AS total FROM studentinfo2";
    $totalRowsResult = $conn->query($totalRowsQuery);
    $totalRows = $totalRowsResult->fetch_assoc()['total'];
    $totalPages = ceil($totalRows / $rowsPerPage);

    // Sorting settings
    $sortColumn = isset($_GET['sort']) ? $_GET['sort'] : 'idNum';
    $sortOrder = isset($_GET['order']) ? $_GET['order'] : 'ASC';

    // Fetch data with sorting [REMOVE AFTER HAVING FIXING SEARCH]
    $query = "SELECT * FROM studentinfo2 $searchCondition ORDER BY $sortColumn $sortOrder LIMIT $offset, $rowsPerPage";
    $result = $conn->query($query);



?>

<!-- ------------------------------------------------------------------------- -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Information</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        th {
            background-color: #f2f2f2;
        }

        .odd {
            background-color: #ffffff; /* Set the background color for odd rows */
        }

        .even {
            background-color: #f9f9f9; /* Set the background color for even rows */
        }

    </style>
    <script>
        function showToast(message, type) {
            Toastify({
                text: message,
                duration: 5000,
                newWindow: true,
                close: true,
                gravity: 'top', // 'top' or 'bottom'
                position: 'right', // 'left', 'center' or 'right'
                backgroundColor: type === 'success' ? '#32CD32' : '#FF6347', // green or red
            }).showToast();
        }

        function togglePasswordVisibility(passwordFieldId, checkboxId) {
            var passwordField = document.getElementById(passwordFieldId);
            var checkbox = document.getElementById(checkboxId);

            if (checkbox.checked) {
                passwordField.type = 'text';
            } else {
                passwordField.type = 'password';
            }
        }



        function validatePassword() {
            var password = document.getElementById('password').value;

            // Password must be at least 8 characters long
            if (password.length < 8) {
                alert('Password must be at least 8 characters long.');
                return false;
            }

            // Password must contain at least one uppercase letter, one lowercase letter, and one digit
            if (!/[A-Z]/.test(password) || !/[a-z]/.test(password) || !/\d/.test(password)) {
                alert('Password must contain at least one uppercase letter, one lowercase letter, and one digit.');
                return false;
            }

            // Password must contain at least one special character (*, _, /)
            if (!/[*_\/]/.test(password)) {
                alert('Password must contain at least one of the following special characters: *, _, /');
                return false;
            }

            return true;
        }

        document.addEventListener("DOMContentLoaded", function () {
            // Call the function to fetch and display the next ID
            fetchNextIdNum();
        });

        function fetchNextIdNum() {
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("nextIdNum").value = this.responseText;
                }
            };
            xhttp.open("GET", "getNextID2.php", true); // Replace with your actual endpoint
            xhttp.send();
        }
        
        function calculateAge() {
            var birthdate = new Date(document.getElementById('birthdate').value);
            var today = new Date();
            var age = today.getFullYear() - birthdate.getFullYear();
            var monthDiff = today.getMonth() - birthdate.getMonth();

            if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthdate.getDate())) {
                age--;
            }

            document.getElementById('age').value = age;
        }

        function calculateAgeOnUpdate() {
            var birthdate = new Date(document.getElementById('updateBirthdate').value);
            var today = new Date();
            var age = today.getFullYear() - birthdate.getFullYear();
            var monthDiff = today.getMonth() - birthdate.getMonth();

            if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthdate.getDate())) {
                age--;
            }

            document.getElementById('updateAge').value = age;
        }

        function editStudent(id, idNum, fname, mname, lname, birthdate, address, password) {
            document.getElementById("updateId").value = id;
            document.getElementById("idNum").value = idNum;
            document.getElementById("updateFirstname").value = fname;
            document.getElementById("updateMiddlename").value = mname;
            document.getElementById("updateLastname").value = lname;
            // document.getElementById("updateEmail").value = email;
            document.getElementById("updateBirthdate").value = birthdate;
            document.getElementById("updateAddress").value = address;
            document.getElementById("updatePassword").value = password;

            calculateAgeOnUpdate();

            document.getElementById("updateForm").style.display = "block";
            document.getElementById("studentInfoForm").style.display = "none";
        }

        function cancelUpdate() {
        // Hide update form and display student info form
        document.getElementById("updateForm").style.display = "none";
        document.getElementById("studentInfoForm").style.display = "block";
        }

        function clearSearch() {
            document.getElementsByName('searchAddress')[0].value = '';
            document.forms[0].submit();
        }

        


    </script>
</head>
<body>
    <div id="left-container">
        <h1>Student Info</h1>

        <form method="post" id="studentInfoForm" onsubmit="return validatePassword();">
            <table>
                <tr>
                    <td><label for="nextIdNum">ID Number:</label></td>
                    <td><input type="text" name="nextIdNum" id="nextIdNum" readonly></td>
                </tr>
                <tr>
                    <td><label for="firstname">First Name:</label></td>
                    <td><input type="text" name="firstname" required></td>
                </tr>
                <tr>
                    <td><label for="middlename">Middle Name:</label></td>
                    <td><input type="text" name="middlename"></td>
                </tr>
                <tr>
                    <td><label for="lastname">Last Name:</label></td>
                    <td><input type="text" name="lastname" required></td>
                </tr>
                <tr>
                    <td><label for="birthdate">Birthdate:</label></td>
                    <td><input type="date" name="birthdate" id="birthdate" placeholder="Birthdate" onchange="calculateAge()" required></td>
                </tr>
                <tr>
                    <td><label for="age">Age:</label></td>
                    <td><input type="number" name="age" id="age" placeholder="Age" readonly></td>
                </tr>
                <tr>
                    <td><label for="address">Address:</label></td>
                    <td><input type="text" name="address" required></td>
                </tr>
                <!-- <tr>
                    <td><label for="email">Email:</label></td>
                    <td><input type="email" name="email" placeholder="Email" required></td>
                </tr> -->
                <tr>
                    <td><label for="password">Password:</label></td>
                    <td><input type="password" name="password" id="password" placeholder="Password" required>
                    <input type="checkbox" id="showPassword" onclick="togglePasswordVisibility('password', 'showPassword')"> Show Password
                </tr>
                
            </table>
            <input type="submit" name="add" value="Add">
            
        </form>
        
        
        <form method="post" style="display: none;" id="updateForm">
        <input type="hidden" name="id" id="updateId">
        <table>
            <tr>
                <td><label for="idNum">ID Number:</label></td>
                <td><input type="text" name="idNum" id="idNum" readonly></td>
            </tr>
            <tr>
                <td><label for="firstname">First Name:</label></td>
                <td><input type="text" name="firstname" id="updateFirstname" required></td>
            </tr>
            <tr>
                <td><label for="middlename">Middle Name:</label></td>
                <td><input type="text" name="middlename" id="updateMiddlename"></td>
            </tr>
            <tr>
                <td><label for="lastname">Last Name:</label></td>
                <td><input type="text" name="lastname" id="updateLastname" required></td>
            </tr>
            <tr>
                <td><label for="birthdate">Birthdate:</label></td>
                <td><input type="date" name="birthdate" id="updateBirthdate" placeholder="Birthdate" onchange="calculateAgeOnUpdate()" required></td>
            </tr>
            <tr>
                <td><label for="age">Age:</label></td>
                <td><input type="number" name="age" id="updateAge" placeholder="Age" readonly></td>
            </tr>
            <tr>
                <td><label for="address">Address:</label></td>
                <td><input type="text" name="address" id="updateAddress" required></td>
            </tr>
            <!-- <tr>
                <td><label for="email">Email:</label></td>
                <td><input type="email" name="email" id="updateEmail" placeholder="Email" required></td>
            </tr> -->
            <tr>
                    <td><label for="password">Password:</label></td>
                    <td><input type="type" name="password" id="updatePassword" placeholder="Password" required>
                    <input type="checkbox" id="showUpdatePassword" onclick="togglePasswordVisibility('updatePassword', 'showUpdatePassword')"> Show Password
                </td>
                </tr>
        </table>
        <input type="submit" name="update" value="Update">
        <input 
            type="button" 
            name="cancel"
            value="Cancel" 
            id="cancel" 
            style="background-color: #d32f2f; 
                color: white;
                padding: 10px;
                cursor: pointer;" 
                onclick="cancelUpdate()">
    </form>

    </div>

    </br>

    <div id="right-container">
    <form method="post">
            <label for="searchAddress">Search:</label>
            <input type="text" name="searchAddress" placeholder="Search by firstname...">
            <input type="submit" name="search" value="Search">
            <input type="submit" name="showAll" value="Show All">
            <button type="button" onclick="clearSearch()">Clear Search</button>
        </form>

    <table border="1">
        <tr>
            <th><a href="?sort=idNum&order=<?php echo $sortOrder === 'ASC' ? 'DESC' : 'ASC'; ?>">ID</a></th>
            <th><a href="?sort=fname&order=<?php echo $sortOrder === 'ASC' ? 'DESC' : 'ASC'; ?>">First Name</a></th>
            <!-- <th>ID</th>
            <th>First Name</th> -->
            <th>Middle Name</th>
            <th><a href="?sort=lname&order=<?php echo $sortOrder === 'ASC' ? 'DESC' : 'ASC'; ?>">Last Name</a></th>
            <!-- <th>Last Name</th> -->
            <!-- <th>Email</th> -->
            <th>Birthdate</th>
            <th>Age</th>
            <th>Address</th>
            <th>Password</th>
            <th>Action</th>
        </tr>
        <?php
        if (isset($result)) {
            $rowNumber = 0;
            while ($row = $result->fetch_assoc()) {
                $rowNumber++;
                $rowClass = $rowNumber % 2 == 0 ? 'even' : 'odd'; // Assign 'even' or 'odd' class
                echo "<tr class='$rowClass'>";
                echo "<td>{$row['idNum']}</td>";
                echo "<td>{$row['fname']}</td>";
                echo "<td>{$row['mname']}</td>";
                echo "<td>{$row['lname']}</td>";
                // echo "<td>{$row['email']}</td>";
                echo "<td>{$row['birthdate']}</td>";
                echo "<td>{$row['age']}</td>";
                echo "<td>{$row['address']}</td>";
                echo "<td>{$row['password']}</td>";
                echo "<td><a href='?delete={$row['id']}'>Delete</a> | <a href='#' onclick='editStudent({$row['id']}, \"{$row['idNum']}\", \"{$row['fname']}\", \"{$row['mname']}\", \"{$row['lname']}\",  \"{$row['birthdate']}\", \"{$row['address']}\", \"{$row['password']}\",)'>Edit</a></td>";
                echo "</tr>";
            }
        }
        ?>
        <!-- \"{$row['email']}\", -->
    </table>

    <div class="pagination">
        <?php
        // for ($i = 1; $i <= $totalPages; $i++) {
        //     // echo "<a href='?page=$i'>$i</a> ";
        //     echo "<a href='?page=$i&sort=$sortColumn&order=$sortOrder'>$i</a> ";
        // }

        // this is to get the search result with pagination
        $pageUrl = isset($searchAddress) ? "&searchAddress=$searchAddress" : "";
        for ($i = 1; $i <= $totalPages; $i++) {
            echo "<a href='?page=$i&sort=$sortColumn&order=$sortOrder$pageUrl'>$i</a> ";
        }
        ?>
    
    </div>


</body>
</html>

<?php
$conn->close(); //close db
?>
