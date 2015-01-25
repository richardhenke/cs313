<?php 
session_start();

$_SESSION["count"] = 10;
$_SESSION["count"]++;

?>
<!DOCTYPE html>
<html>
<head>
	<title>Session Testing</title>
	</head>
	<body>
		<div>
			<div>
				The session data has been set;
			</div>
		</div>
	</body>
	</html>