<!DOCTYPE html>
<html>
<head>
    <title>Activity 2</title>
</head>
<body>
    <form method="GET" action="compute.php">
        Enter 1st no.: <input type="text" name="num1" required /> <br /><br />
		Enter 2nd no.: <input type="text" name="num2" required /> <br /><br />
        Select Operation:
			<br />
			<input type="radio" name="operation" required value="addition" /> Addition <br />
			<input type="radio" name="operation" required value="subtraction" /> Subtraction <br />
			<input type="radio" name="operation" required value="multiplication"/> Multiplication <br />
			<input type="radio" name="operation" required value="division" /> Division <br />		
			<br />
            <input type="submit" name="compute" value="Compute"><br/><br/>
            
    </form>
</body>
</html>
    