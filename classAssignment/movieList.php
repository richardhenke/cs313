<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Movie List</title>
</head>
<body>
	<div>
	<?php 
	try {
		$user = 'phpbob';
		$password = 'cs313pass';
		$query = "Mark Hammil";

		$db = new PDO("mysql:host=locolhost;dbname=movieTest", $user, $password);
		echo "Connection Established!";

		$sql = "SELCECT name FROM actor WHERE name=:name";
		$statment = $db->prepare($sql);
		$statment->bindValue(':name', $query. PDO::PRAM_STR);
		$statment->execute();

		while ($row = $statment->fetch(PDO::FETCH_ASSOC)) 
		{
			echo "Found: " . $row["name"] . "<br />\n";
		}
	} catch (PDOEception $ex) {
		echo "Error: " . $ex->getMessage();
		die();
	}

	?>
	</div>
</body>
</html>