<html>
	<head>
		<title>Compute Math</title>
	</head>
	<body>
		<?php
			$num1value;
			$num2value;
			
			$sum;
			$difference;
			$product;
			$quotient;
			
			//check if the user has clicked the button compute
			if(isset($_GET["compute"]))
			{
				//get the inputted value of num1
				$num1value = $_GET["num1"];
				//get the inputted value of num2value
				$num2value = $_GET["num2"];
				
				//perform the operations
				$sum = $num1value + $num2value;
				$difference = $num1value - $num2value;
				$product = $num1value * $num2value;
				
				//display the results
				echo "<p>Sum: ".$sum."</p>";
				echo "<p>Difference: ".$difference."</p>";
				echo "<p>Product: ".$product."</p>";				
				if($num2value == 0)
				{
					echo "<p>Sorry, cannot divide number by zero.</p>";					
				}
				else 
				{
					$quotient = $num1value / $num2value;
					echo "<p>Quotient: ".$quotient."</p>";
				}
						
				
			}
			
		?>
	</body>
</html>