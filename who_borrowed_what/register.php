
<form action="." method="POST" class='newTransaction' enctype="multipart/form-data">

<label for='name_first'>First Name:</label>
<input type='text' name='name_first' id='name_first'>

<label for='name_last'>Last Name:</label>
<input type='text' name='name_last' id='name_last'>

<label for='email'>Email:</label>
<textarea name='email' id='email'></textarea>

<label for='phone_number'>Phone Number</label>
<input type='text' name='phone_number' placeholder='(123) 456-7890'>


<label for='fileToUpload'>Item Image:</label>
<input type="file" name="fileToUpload" id="fileToUpload">
<input type="submit" value="Finished" name="upload">
</form>