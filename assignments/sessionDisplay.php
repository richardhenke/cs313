<?php 
session_start();
if (isset($_SESSION['count'])){
	$_SESSION['count']++;
}

$myfile = fopen("surveyData.txt", "a") or die("Unable to open file!");
$txt = "John Doe";

$myString = "";
for ($i = 0; $i < 10; $i++) {
	$myString .= " $i ";
}
fwrite($myfile, $txt);
fclose($myfile);

$myfile = fopen("surveyData.txt", "r") or die("Unable to open file!");
// Output one line until end-of-file

while(!feof($myfile)) {
	//echo fgets($myfile) . "<br>";
	$myString . fgets($myfile) . "<br>";
}
fclose($myfile);


?>
<!DOCTYPE html>
<html>
<head>
	<title>Session Testing</title>
</head>
<body>
	<div>
		<?php 
		//echo "The session varialbe is: " . $_SESSION["count"];
		//echo $myString;
		//$pizza  = array("piece1", "piece2", "piece3", "piece4", "piece5", "piece6");
		// $pieces = explode(" ", $pizza);
		$pizza  = "piece1 piece2 piece3 piece4 piece5 piece6";
		$pieces = explode(" ", $pizza);

		foreach ($pieces as $value) {
			echo "$value";
		} 




		?>
	</div>
</body>
</html>


<!-- 
// Example 2
$data = "foo:*:1023:1000::/home/foo:/bin/sh";
list($user, $pass, $uid, $gid, $gecos, $home, $shell) = explode(":", $data);
echo $user; // foo
echo $pass; // * -->