
<form action="." method="POST" class='newTransaction' enctype="multipart/form-data">
 <label for='lendTo'>Lend to:</label>
 <?php 
 $users = getUsers();
 echo "<select name='lendTo'>";
 foreach ($users as $key => $user) {
   // Don't display users own name as an option.
   if ($user['user_id'] != $_SESSION['user_id']) {
      echo "<option name='user_id' value='$user[user_id]'>$user[name_first] $user[name_last]</option>";
   }
}
echo "</select>";
?>

<label for='item_name'>Item Name:</label>
<input type='text' name='item_name' id='item_name'>

<label for='tags'>Item Tag:</label>
<input type='text' name='tags' id='tags'>

<label for='description'>Item Description:</label>
<textarea name='description' id='description'></textarea>

<label for='return_date'>Return Date</label>
<input type='date' name='return_date' placeholder='YYYY-MM-DD'>


<label for='fileToUpload'>Item Image:</label>
<input type="file" name="fileToUpload" id="fileToUpload">
<input type="submit" value="Finished" name="upload">
</form>