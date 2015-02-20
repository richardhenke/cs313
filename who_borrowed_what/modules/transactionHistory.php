      <!-- Main Content Module: Transactions view -->
      <!-- Print message if any -->
      <?php displayMessage($message); ?>
      <h1><?php echo $_SESSION['name_first'] . "'s Borrowed History";?></h1>
      <div class='borrowed_view'>
        <?php 
        $borrowedTransactions = getBorrowedTransactions($_SESSION['user_id'], -1);
        foreach ($borrowedTransactions as $key => $value) {
          displayTransaction($value);
       }
       ?>

     </div>
     <h1><?php echo $_SESSION['name_first'] . "'s Lent History";?></h1>
     <div class="lent_view">
      <?php 
      $lentTransactions = getLentTransactions($_SESSION['user_id'], -1);
      foreach ($lentTransactions as $key => $value) {
       displayTransaction($value);
     }
     ?>