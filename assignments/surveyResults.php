<?php 
session_start();
//session_destroy();
if (!empty($_POST)) {
	$_SESSION['redirect'] = true;
}
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

if (!empty($_POST)) {
// Separate values from data read in from file
	splitQuestion($sarcastic);
	if (isset($_POST['surveyChoice1'])) {
		updatePoll($_POST['surveyChoice1']);
	}
	$sarcastic = "$_SESSION[ironMan]:$_SESSION[spiderman]:$_SESSION[flash]:$_SESSION[raphael]";

// Separate values from data read in from file
	splitQuestion($favorite);
	if (isset($_POST['surveyChoice2'])) {
		updatePoll($_POST['surveyChoice2']);
	}
	$favorite = "$_SESSION[ironMan]:$_SESSION[spiderman]:$_SESSION[flash]:$_SESSION[raphael]";

// Separate values from data read in from file
	splitQuestion($strongest);
	if (isset($_POST['surveyChoice3'])) {
		updatePoll($_POST['surveyChoice3']);
	}
	$strongest = "$_SESSION[ironMan]:$_SESSION[spiderman]:$_SESSION[flash]:$_SESSION[raphael]";
	

// Separate values from data read in from file
	splitQuestion($coolest);
	if (isset($_POST['surveyChoice4'])) {
		updatePoll($_POST['surveyChoice4']);
	}
	$coolest = "$_SESSION[ironMan]:$_SESSION[spiderman]:$_SESSION[flash]:$_SESSION[raphael]";
	

// Save results back to file
	$myfile = fopen("surveyData.txt", "r+") or die("Unable to open file!");
	$txt = "$sarcastic $favorite $strongest $coolest";
	fwrite($myfile, $txt);
	fclose($myfile);
}

// Save all categories into an array for printing below scores
$categories = array($sarcastic, $favorite, $strongest, $coolest);
// Save all categories into an array for printing below names
$category_names = array("Sarcastic", "Favorite", "Strongest", "Coolest");
// // Save all categories into an array for printing below pictures
$pictures = array("../pictures/ironman.jpg", "../pictures/spiderman.jpg", "../pictures/flash.png", "../pictures/raphael.jpg");
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
			<h1>Character Results</h1>
			<?php

			$i = 0;
			$j = 0;
			while ($i < 5) 
			{ 
				echo "<div  class='column_grid'>";
				if ($i != 0) 
				{
					echo "<div class='pictures'><img src='" . $pictures[$i - 1] . "' alt='Photo of ". getName($i - 1) ."'></div>";
				}
				while ($j < 4) 
				{
					if ($i > 0) 
					{ 
						echo "<div class='row_grid'>";
						echo splitQuestion($categories[$j])[$i - 1];
						echo "</div>";
					} else {
						echo "<div class='categories row_grid'>" . $category_names[$j] . "</div>";
					}
					$j++;
				}
				echo "</div>";
				$j = 0;
				$i++;
			}
			
			if (empty($_POST) && empty($_SESSION['redirect'])) { ?>
			<form action='survey.php'>
				<input type='submit' value='Vote'>
			</form>
			<?php } ?>
		</div>
	</div>	
</body>
</html>