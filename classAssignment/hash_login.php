<!DOCTYPE html>
<!-- This is the View in the MVC pattern -->
<html lang="en">
<head>
 <meta charset="UTF-8">
 <title>Password Hash | Login</title>
</head>
<body>
   <form action="hash_home.php" method='POST'>

    <label >Username:</label>
    <input type="username" name="username" required >

    <label >Password:</label>
    <input type="password" name="password" required >
    <br><br>
    <input type="submit" value="Login" name='submited'>
  </form>
  <button name='register'><a href='hash_register.php'>Register</a></button>

</body>
</html>