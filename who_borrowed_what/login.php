<?php 
// Get access to the session
if (!isset($_SESSION)) {
  session_start();

}
// This variable will be used to display information about submissions or data changes
$message = "";
// Get access to the model
include 'model.php';
// Get access to the custom functions library
include 'library/functions.php';

// Check to see if user has already logged in
if (!isset($_SESSION['loggedin'])) {
// Check if user submitted login info
  if (isset($_POST['submited']) && $_POST['submited'] == 'Login') {
    $userInfo = login($_POST['email'], $_POST['password']);
    if (is_array($userInfo)) {
      foreach ($userInfo as $key => $value) {
       echo $_SESSION['user_id'] = $value['user_id'];
       echo $_SESSION['name_first'] = $value['name_first'];
       echo $_SESSION['name_last'] = $value['name_last'];
       echo $_SESSION['phone_number'] = $value['phone_number'];
       echo $_SESSION['email'] = $value['email'];
       echo  $_SESSION['profile_picture'] = $value['profile_picture'];
       echo  $_SESSION['loggedin'] = "TRUE";
     }
     header("Location: home.php");
     die();
   } else {
    $_SESSION['message'] = "There was an error in logging in: ";
    header("Location: login.php");
    die();
  }
  // Check if user wants to register
} else if (isset($_GET['name']) && $_GET['name'] == 'r') {
  header("Location: register.php");
  die();
  // If nothing has been subbmited and not logged in then display form
} else { ?>
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
  <div class='login'>
    <form action="login.php" method='POST'>
     <?php
     echo "<p>";
     if (isset($_SESSION['message'])) {displayMessage($_SESSION['message']);}
     echo "</p>";
     ?>

     <label >Email:</label>
     <input type="email" name="email" required placeholder="example@example.com">

     <label >Password:</label>
     <input type="password" name="password" required >
     <span id='button_wrapper'>
       <input type="submit" value="Login" name='submited'>
       <a class='custom_button' href='?name=r'>Register</a>
     </span>
   </form>

 </div>

</body>
</html>

<?php
}
// If the user IS LOGGED IN send to home page.
} else {
  header("Location: home.php");
  die();
}
?>