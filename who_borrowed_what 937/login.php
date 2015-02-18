<!DOCTYPE html>
<!-- This is the View in the MVC pattern -->
<html lang="en">
<head>
 <meta charset="UTF-8">
 <title>Who Borrowed What | Login</title>
 <link rel="stylesheet" type="text/css" href="css/who_bowwored_what.css" media="screen" >
</head>
<body>
  <div class="filter"></div>
  <div class='popout'>
   <form action="index.php" method='POST'>

    <label >Email:</label>
    <input type="email" name="email" required placeholder="example@example.com">

    <label >Password:</label>
    <input type="password" name="password" required >
    <br><br>
    <input type="submit" value="Login" name='submited'>
  </form>
  <button name='register'><a href='?name=r'>Register</a></button>
</div>

</body>
</html>