<?php 
session_start();

function updatePoll($answer) {

	switch($answer) {
		case 1:
		$_SESSION['ironMan']++;
		break;
		case 2:
		$_SESSION['spiderman']++;
		break;
		case 3:
		$_SESSION['flash']++;
		break;
		case 4:
		$_SESSION['raphael']++;
		break;
		default:
		break;
	}
}

function getName($question) {

	switch($question) {
		case 0:
		return "Iron Man";
		break;
		case 1:
		return "Spiderman";
		break;
		case 2:
		return "Flash";
		break;
		case 3:
		return "Raphael";
		break;
		default:
		break;
	}
}

function splitQuestion($question) {
	return	list($_SESSION['ironMan'], $_SESSION['spiderman'], $_SESSION['flash'], $_SESSION['raphael']) = explode(":", $question);
}


// open file if exists
$myfile = fopen("surveyData.txt", "r") or die("Unable to open file!");

$myString = "";
// Read file data into string
while(!feof($myfile)) {
	$myString .= fgets($myfile);
}
// close file
fclose($myfile);

list($sarcastic, $favorite, $strongest, $coolest) = explode(" ", $myString);

// Separate values from data read in from file
splitQuestion($sarcastic);
updatePoll($_POST['surveyChoice1']);
$sarcastic = "$_SESSION[ironMan]:$_SESSION[spiderman]:$_SESSION[flash]:$_SESSION[raphael]";
echo "<br>Sarcastic: " . $sarcastic;

// Separate values from data read in from file
splitQuestion($favorite);
updatePoll($_POST['surveyChoice2']);
$favorite = "$_SESSION[ironMan]:$_SESSION[spiderman]:$_SESSION[flash]:$_SESSION[raphael]";
echo "<br>Favorite: " . $favorite;

// Separate values from data read in from file
splitQuestion($strongest);
updatePoll($_POST['surveyChoice3']);
$strongest = "$_SESSION[ironMan]:$_SESSION[spiderman]:$_SESSION[flash]:$_SESSION[raphael]";
echo "<br>Strongest: " . $strongest;

// Separate values from data read in from file
splitQuestion($coolest);
updatePoll($_POST['surveyChoice4']);
$coolest = "$_SESSION[ironMan]:$_SESSION[spiderman]:$_SESSION[flash]:$_SESSION[raphael]";
echo "<br>Coolest: " . $coolest;

// Save results back to file
$myfile = fopen("surveyData.txt", "r+") or die("Unable to open file!");
$txt = "$sarcastic $favorite $strongest $coolest";
fwrite($myfile, $txt);
fclose($myfile);

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="../css/survey.css" media="screen" >
	<title>Assignments | Sarcastic Survey </title>

</head>
<body>
	<div id="wrapper_body">
		<div class="main_content">
			<div id='sarcastic'>
				<?php 

				for ($i = 0; $i < 4; $i++) {
					echo "<span class='hero_$i' >";
					echo splitQuestion($sarcastic)[$i];
					echo "</span>";
					echo "<span class='hero_name'>";
					echo getName($i);
					echo"</span>";
				}

				?>
			</div>
			<div id='favorite'>
				<?php 

				for ($i = 0; $i < 4; $i++) {
					echo "<span class='hero_$i' >";
					echo splitQuestion($favorite)[$i];
					echo "<span class='hero_name'>";
					echo getName($i);
					echo"</span>";
					echo "</span>";
					
				}

				?>
			</div>
			<div id='strongest'>
				<?php 

				for ($i = 0; $i < 4; $i++) {
					echo "<span class='hero_$i' >";
					echo splitQuestion($strongest)[$i];
					echo "<span class='hero_name'>";
					echo getName($i);
					echo"</span>";
					echo "</span>";
				}

				?>
			</div>
			<div id='coolest'>
				<?php 

				for ($i = 0; $i < 4; $i++) {
					echo "<span class='hero_$i' >";
					echo splitQuestion($coolest)[$i];
					echo "<span class='hero_name'>";
					echo getName($i);
					echo"</span>";
					echo "</span>";
				}

				?>
			</div>
		</div>
	</div>
</body>
</html>