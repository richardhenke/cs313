<?php 
// Get access to the session
if (!isset($_SESSION)) {
 session_start();
  // If they haven't logged in then pull up login screen
 if (!isset($_SESSION['loggedin'])) {
    header("Location: login.php");
    die();
 }
}
// This variable will be used to display information about submissions or data changes
$message = "";
// Get access to the model
include 'model.php';
// Get access to the custom functions library
include 'library/functions.php';

?>
<!DOCTYPE html>
<!-- This is the View in the MVC pattern -->
<html lang="en">
<head>
   <meta charset="UTF-8">
   <title>Who Borrowed What | Home</title>
   <link rel="stylesheet" type="text/css" href="css/who_bowwored_what.css" media="screen" >
</head>
<body>

</div>

<header class='main_nav'>
   <div id='logo'>
      <a href='home.php'>WBW</a>
   </div>
   <div id='personalized_welcome'><?php personalizedWelcome();?></div>
</header>

<main>
   <!-- Show side nav bar -->
   <?php include 'modules/sideNavBar.php'; ?>

   <div class='main_content'>
      <?php
      if (!empty($_GET) && $_GET['name'] == "nt") {
         include "modules/newTransaction.php";
      } else if (!empty($_GET) && $_GET['name'] == "th") {
         $_SESSION['FROM_URL'] = $_SERVER['QUERY_STRING'];
         include 'modules/transactionHistory.php';
      } else if (!empty($_GET) && $_GET['name'] == "ct") {
         updateTransaction($_GET['value'], "NO");
         if (isset($_SESSION['FROM_URL'])) {
            parse_str($_SESSION['FROM_URL']);
            if ($name == 'th') {           
               include "modules/transactionHistory.php";
            }
            unset($_SESSION['FROM_URL']);
         } else {
            include "modules/transactionsView.php";
         }    
      } else if (!empty($_POST['upload'])) {
         if (!empty($_FILES['fileToUpload']['name'])) {
            $okToUpload = imageUpload(isset($_POST));
            if ($okToUpload) {
               createTransaction($_SESSION['item_picture']);
            }
            include "modules/transactionsView.php";
         } else {
            $_SESSION['message'] = "You didn't select a file to upload.";
         }
      } else {
         include "modules/transactionsView.php";
      }
      ?>
   </div>
</div>
</main>

<footer>
   <p id='copyright'>Copyright (c) 2015 Richard Henke</p>
   <p>|</p>
   <p id='footer_date'><?php echo 'Last Updated: ' . date('j F, Y', getlastmod()); ?></p>
</footer>

</body>
</html>