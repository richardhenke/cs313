      <!-- Main Content Module: Transactions view -->
      <!-- Print message if any -->
      <?php if (isset($_SESSION['message'])) {displayMessage($_SESSION['message']);} ?>
      <h1><?php echo $_SESSION['name_first'] . " Has Borrowed";?></h1>
      <div class='borrowed_view'>
        <?php 
        $borrowedTransactions = getBorrowedTransactions($_SESSION['user_id'], 1);
        foreach ($borrowedTransactions as $key => $value) {
          displayBorrowedTransaction($value);
       }
       ?>

     </div>
     <h1><?php echo $_SESSION['name_first'] . " Has Lent";?></h1>
     <div class="lent_view">
      <?php 
      $lentTransactions = getLentTransactions($_SESSION['user_id'], 1);
      foreach ($lentTransactions as $key => $value) {
       displayLentTransaction($value);
     }
     ?>
   </div>