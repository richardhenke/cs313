<?php 
// Bring in the View of the MVC pattern
if (!isset($_SESSION['loggedin'])) {
//header( 'Location: http://www.yoursite.com/new_page.html' ) 
   header('Location: index.php');
}
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
   <div id='logo'>Logo</div>
   <div id='personalized_welcome'><?php personalizedWelcome();?></div>
</header>

<main>
   <div class='side_nav'> 
      <ul>
         <li><a href='?name=nt'>New Transation</a></li>
         <li>Borrowed History</li>
         <li>Lent History</li>
      </ul>
   </div>

   <div class='main_content'>
      <?php
      if (!empty($_GET) && $_GET['name'] == "nt") {
         include "modules/newTransaction.php";
      } else if (!empty($_POST['upload'])) {
         // if (!empty($_FILES['fileToUpload']['name'])) {
         //    $name=$_FILES["file"]["name"];

         //    if ($_FILES["file"]["error"] > 0) {
         //      echo "Return Code: " . $_FILES["file"]["error"] . "<br>";
         //   }
         //   else {
         //      echo "Upload: " . $_FILES["file"]["name"] . "<br>";
         //      echo "Type: " . $_FILES["file"]["type"] . "<br>";
         //      echo "Size: " . ($_FILES["file"]["size"] / 1024) . " kB<br>";
         //      echo "Temp file: " . $_FILES["file"]["tmp_name"] . "<br>";

         //      if (file_exists($_ENV["OPENSHIFT_DATA_DIR"] . "pictures/items/". $_FILES["file"]["name"])) {
         //       echo $_FILES['file']['name'] . " already exists. ";
         //       echo unlink($_ENV['OPENSHIFT_DATA_DIR'] . "pictures/items/". $_FILES['file']['name']);
         //    }

         //    move_uploaded_file($_FILES["file"]["tmp_name"], $_ENV['OPENSHIFT_DATA_DIR'] . "pictures/items/". $_FILES["file"]["name"]);
         //    echo "Stored in: " . $_ENV['OPENSHIFT_DATA_DIR'] . "pictures/items/" . $_FILES['file']['name'];


         //    echo "<img src='" . $_ENV["OPENSHIFT_DATA_DIR"] . "pictures/items/". $_FILES["file"]["name"] . "' />";

         //createTransaction($item_picture);
            include "modules/transactionsView.php";
         } else {
            echo "You didn't select a file to upload.";
         }

      } else {
         include "modules/transactionsView.php";
      }
      ?>
   </div>

</div>
</main>

<footer>
   <p>Footer</p>
   <p><?php echo 'Last Updated: ' . date('j F, Y', getlastmod()); ?></p>
</footer>

</body>
</html>