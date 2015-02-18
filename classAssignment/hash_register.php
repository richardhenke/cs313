<!DOCTYPE html>
<!-- This is the View in the MVC pattern -->
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Password Hash | Register</title>
</head>
<body>
	<form action="hash_home.php" method='POST'>

		<label >Username:</label>
		<input type="username" name="username" required >
		<br><br>

		<label >Password:</label>
		<input type="password" name="password" required >
		<br>

		<label >Confirm Password:</label>
		<input type="confirm_password" name="confirm_password" required >
		<br><br>

		<input type="submit" value="Register" name='register'>
	</form>

</body>
</html>