<html>
    <head>
        <title>Activity 3</title>
    </head>
    <body>
        <?php

        $num1 = $_GET['num1'];
        $num2 = $_GET['num2'];

        echo "<table border='1' width='25%'>";
        for($i = 1; $i <= $num1; $i++){
            echo "<tr>";
            for($j = 1; $j <= $num2; $j++){
                echo "<td align='center'>" .$i * $j. "</td>";
            }
            echo "</tr>";
        }
        echo "</table>";

        ?>
    </body>
</html>
