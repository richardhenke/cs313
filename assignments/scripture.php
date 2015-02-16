<?php
include 'scriptures_functions.php';

echo "<form action='displayScriptures.php' method='POST'>
<h2>Book</h2>
<input type='text' name='book'><br>
<h2>Chapter</h2>
<input type='text' name='chapter'><br>
<h2>Verse</h2>
<input type='text' name='verse'><br>
<h2>Content</h2>
<textarea name='content'></textarea><br>
";
$topics = getTopics();
foreach ($topics as $key => $value) {
	echo "<input type='checkbox' name='value[]' value='value[]' > $value[$key]";
}

echo "<input type='submit' value='submit'> 
</form>";


?>