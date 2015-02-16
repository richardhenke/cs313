      <!-- Main Content Module: Transactions View -->
      <h1><?php echo $_SESSION['name_first']." Has Borrowed:";?></h1>
      <div class='borrowed_view'>
        <?php 
        $borrowedTransactions = getBorrowedTransactions($_SESSION['user_id']);
        foreach ($borrowedTransactions as $key => $value) {
         echo "<div class='transaction'><div class='trans_left'>";
         echo "<img class='trans_item_picture' src='" . $value['item_picture'] . "' /><span class='trans_item_name'>". $value['name'] . "</span></div>";
         echo "<span class='to_or_from'>From</span>"; 
            #echo "<div class-'arrow'><div class=''></div><div class='arrow-right'></div></div>";
         echo "<div class='trans_right'> <img class='trans_user_picture' src='" . $value['profile_picture'] . "' /><span class='trans_user_name'>" . $value['name_first'] . " " . $value['name_last'] . "</span></div>";
         echo "</div>";
      }
      ?>

   </div>
   <h1><?php echo $_SESSION['name_first']." Has Lent:";?></h1>
   <div class="lent_view">
      <?php 
      $lentTransactions = getLentTransactions($_SESSION['user_id']);
      foreach ($lentTransactions as $key => $value) {
         echo "<div class='transaction'><div class='trans_left'>";
         echo "<img class='trans_item_picture' src='" . $value['item_picture'] . "' /><span class='trans_item_name'>". $value['name'] . "</span></div>";
         echo "<span class='to_or_from'>To</span>";
            #echo "<div class-'arrow'><div class=''></div><div class='arrow-right'></div></div>";
         echo "<div class='trans_right'> <img class='trans_user_picture' src='" . $value['profile_picture'] . "' /><span class='trans_user_name'>" . $value['name_first'] . " " . $value['name_last'] . "</span></div>";
         echo "</div>";
      }
      ?>