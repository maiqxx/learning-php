<html>
    <head>
        <title>Activity 4</title>
    </head>
    <body>
        <?php

        $num1 = $_GET['num1'];
        $num2 = $_GET['num2'];
        
        if(isset($_GET["compute"])){
            
            //checks if textboxes are empty
            if(($num1 && $num2) == ""){
                echo "<p> Please input a value. </p>";
            } 
            //checks if inputs are numeric
            else if(!is_numeric($num1) || !is_numeric($num2)){
                echo "<p> Inputs must be numeric. </p>";
            } 

            //checks if inputs are whole numbers
            else if ((int)$num1 != (float)$num1){
                echo "<p> Inputs must be whole numbers. </p>";
            }
            else if((int)$num2 != (float)$num2){
                echo "<p> Inputs must be whole numbers. </p>";
            }

            //checks the minimum and maximum values entered by the user
            else if($num1 > 50 || $num1 < 10){
                echo "<p>Values must not exceed 50 and less than 10.</p>";
            }else if($num2 > 50 || $num2 < 10)
                echo "<p>Values must not exceed 50 and less than 10.</p>";
            else{
                echo "<table border='1' width='25%'>";
                for($i = 1; $i <= $num1; $i++){
                    echo "<tr>";
                    for($j = 1; $j <= $num2; $j++){
                        echo "<td align='center'>" .$i * $j. "</td>";
                    }
                    echo "</tr>";
                }
                echo "</table>";
            }
        }
        ?>
    </body>
</html>
