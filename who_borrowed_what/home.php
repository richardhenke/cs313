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

   <header class='main_nav'>
      <div id='logo'>Logo</div>
      <div id='personalized_welcome'><?php personalizedWelcom();?></div>
   </header>

   <main>
      <div class='side_nav'> 
         <ul>
            <li>New Transation</li>
            <li>Borrowed History</li>
            <li>Lent History</li>
         </ul>
      </div>

      <div class='main_content'>
         <h1>Main Content</h1>
         <div class='borrowed_view'>

         </div>
         <div class="lent_view">

         </div>
         <?php 
         $borrowedTransactions = getBorrowedTransactions($_SESSION['user_id']);
         foreach ($borrowedTransactions as $key => $value) {
            echo "<div class='transaction'><div class='trans_left'>";
            echo "<img class='trans_item_picture' src='" . $value['item_picture'] . "' /><span class='trans_item_name'>". $value['name'] . "</span></div>";
            echo "<div class='trans_right'> <img class='trans_user_picture' src='" . $value['profile_picture'] . "' /><span class='trans_user_name'>" . $value['name_first'] . " " . $value['name_last'] . "</span></div>";
            echo "</div>";
         }
         ?>
      </div>
   </main>

   <footer>
      <p>Footer</p>
      <p><?php echo 'Last Updated: ' . date('j F, Y', getlastmod()); ?></p>
   </footer>

</body>
</html>