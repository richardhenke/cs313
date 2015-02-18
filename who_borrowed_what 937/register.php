<!DOCTYPE html>
<!-- This is the View in the MVC pattern -->
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Who Borrowed What | Register</title>
	<link rel="stylesheet" type="text/css" href="css/who_bowwored_what.css" media="screen" >
</head>
<body>
	<div class="filter"></div>
	<div class='popout'>
		<form action="." method="POST" class='newTransaction'>

			<label for='name_first'>First Name:</label>
			<input required type='text' name='name_first' id='name_first'>

			<label for='name_last'>Last Name:</label>
			<input required type='text' name='name_last' id='name_last'>

			<label for='email'>Email:</label>
			<input required type='email' name='email' id='email'>

			<label for='phone_number'>Phone Number</label>
			<input type='text' name='phone_number' placeholder='(123) 456-7890'>

			<label for='password'>Password:</label>
			<input required type='password' name='password' >

			<label for='password_confirm'>Confirm Password:</label>
			<input required type='password' name='password_confirm' >

			<input required type="submit" value="Register" name="submited">
		</form>
	</div>
</body>
</html>