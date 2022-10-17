<html>
<head>
    <title>Activity 1</title>
</head>
<body>
    <?php

        //declaring variables
        $num1 = $_GET['num1'];
        $num2 = $_GET['num2'];
        $operation = $_GET['operations'];
        $sum = 0;
        $difference = 0;
        $product = 0;
        $quotient = 0;

        //computations
        if($operation == "addition"){
            //addition
            $sum = $num1 + $num2;
            echo $num1 . " + " . $num2 . " = " . $sum;

        }else if($operation == "subtraction"){
            //subtraction
            $difference = $num1 - $num2;
            echo $num1 . " - " . $num2 . " = " . $difference;

        }else if($operation == "multiplication"){
            //multiplication
            $product = $num1 * $num2;
            echo $num1 . " * " . $num2 . " = " . $product;

        }else if($operation == "division"){
            //division
            if($num2 == 0){
                echo "<p>Sorry, cannot divide number by zero.</p>";	
            }else{
                $quotient = $num1 / $num2;
                echo $num1 . " / " . $num2 . " = " . $quotient;
            }
        }
    ?>
    <br /><br />
    <a href="input.php">Go Back</a>
</body>
</html>