<!DOCTYPE html>
<html>
<head>
	<title>Upload an image</title>
</head>
<body>
	<form action='index.php' method="POST" enctype="multipart/form-data">
		File:
		<input type='file' name='image'> <input type='submit' value='Upload'>
	</form>

	<?php 
	echo "here";
	include '../who_borrowed_what/library/functions.php';
	
	$conn = connectDb();

	$file = $_FILES['image']['tmp_name'];
	echo $file;




	?>
</body>
</html>

