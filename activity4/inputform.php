<!DOCTYPE html>
<html>
<head>
    <title>Activity 4</title>
</head>
<body>
<br /><br />
    <form method="GET" action="displayform.php">
        <!-- input type is number - cannot input any characters or symbols -->
        <!-- textboxes requires inputs -->
        Enter rows: <input type="text" name="num1" min="10" max="50" required /> <br /><br />
		Enter columns: <input type="text" name="num2" min="10" max="50" required /> <br /><br />
        <input type="submit" name="compute" value="Display"><br/><br/>
        
    </form>
</body>
</html>