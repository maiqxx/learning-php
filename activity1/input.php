<!DOCTYPE html>
<html>
<head>
    <title>Activity 1</title>
</head>
<body>
    <form method="GET" action="compute.php">
        Enter 1st no.: <input type="text" name="num1" required /> <br /><br />
		Enter 2nd no.: <input type="text" name="num2" required /> <br /><br />
        <label for="operations">Select Operation:</label>
        <select name="operations" id="operations">
            <option value="addition">Addition</option>
            <option value="subtraction">Subtraction</option>
            <option value="multiplication">Multiplication</option>
            <option value="division">Division</option>
        </select><br/><br />
        <input type="submit" name="compute" value="Compute">
    </form>
</body>
</html>
    