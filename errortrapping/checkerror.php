<html>
	<head>
		<title>Check Error</title>
	</head>
	<body>
		<?php
		
			$value = "";
			
			if(isset($_GET["check"]))
			{
				$value = trim($_GET["input"]);
				
				//check if the user has inputted a value
				if($value == "")
				{
					echo "<p>Input error. Textbox input must have a value. Please try again.</p>";
					
				}
				//check if the inputted value is a number by using is_numeric
				else if(! is_numeric($value) )
				{
					echo "<p>Input Error. Input value must be a number. Please enter any number from 0-9.</p>";
					
				}
				//check if the inputted value is a whole number
				// step 1.: convert the inputted value to double using doubleval
				// step 2.: cast the converted double value to int
				// step 3.: compare the converted int value to the original double value
				else if( (int)doubleval($value) != doubleval($value))
				{
					echo "<p>Input Error. Input value must be a whole number.</p>";
					
				}
				
			}
		
		
		?>
	</body>
</html>