<?php 
$name = "userId";
$value = "rhenke";
$visitsKey = "visits";
$count = 0;

if (isset($_COOKIE[$visitsKey])) 
{
	$count = $_COOKIE[$visitsKey];
	$count++;
}

setcookie($visitsKey, $count, time() * 60);
setcookie($name, $value, time() * 60);
setcookie("password", "cs313", time() * 60);

?>
<!DOCTYPE html>
<html>
<head>
	<title>Cookie Testing</title>
</head>
<body>
	<div>
		<p>This is a page to test cookies!</p>
		<?php 
		if (isset($_COOKIE["userId"])) {
			echo "Welcome: " . $_COOKIE['userId'] . "!";
		}
		echo "You have visited this page: " . $_COOKIE['visits'] . " times!";

		?>
	</div>
</body>
</html>