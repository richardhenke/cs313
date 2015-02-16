<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
</head>
<body>
	<?php 
	echo "<h2>Name: $_POST[name]</h2>";
	echo "<a href='mailto:$_POST[email]'>$_POST[email]</a>";
	echo "<h2>Major: $_POST[major]</h2>";
	echo "<h2>Places you've been:</h2>";
	echo "<ul>";
	if (isset($_POST['countries']))
	{
		foreach ($_POST['countries'] as $value) {
			echo "<li> $value </li>";
		}
	}
	echo "</ul>";

	echo "<h2>Comments:</h2><p>$_POST[comments]</p>";


	?>
</body>
</html>