<?php 

if (session_status() == PHP_SESSION_NONE) {
	session_start();
}
if (isset($_SESSION['redirect'])) {
	//header( 'Location: http://www.yoursite.com/new_page.html' ) 
	header( 'Location: surveyResults.php' ); 
}

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="../css/survey.css" media="screen" >
	<title>Assignments | Character Survey </title>
</head>
<body>
	<div id="wrapper_body">
		<div class="main_content">
			<h1>Character Survey</h1>
			<div id="picture_banner">
				<img src='../pictures/ironman.jpg' alt='Iron Man Photo'>
				<img src='../pictures/spiderman.jpg' alt='Spiderman Photo'>
				<img src='../pictures/flash.png' alt='The Flash Photo'>
				<img src='../pictures/raphael.jpg' alt='Raphael Photo'>
			</div>
			<hr />
			<form action="surveyResults.php" method="POST">
				<h2>Who's more sarcastic?</h2>
				<input type="radio" name="surveyChoice1" value="1">Iron Man<br>
				<input type="radio" name="surveyChoice1" value="2">Spiderman<br>
				<input type="radio" name="surveyChoice1" value="3">Flash<br>
				<input type="radio" name="surveyChoice1" value="4">Raphael<br>
				<h2>Who's your favorite?</h2>
				<input type="radio" name="surveyChoice2" value="1">Iron Man<br>
				<input type="radio" name="surveyChoice2" value="2">Spiderman<br>
				<input type="radio" name="surveyChoice2" value="3">Flash<br>
				<input type="radio" name="surveyChoice2" value="4">Raphael<br>
				<h2>Who's the strongest?</h2>
				<input type="radio" name="surveyChoice3" value="1">Iron Man<br>
				<input type="radio" name="surveyChoice3" value="2">Spiderman<br>
				<input type="radio" name="surveyChoice3" value="3">Flash<br>
				<input type="radio" name="surveyChoice3" value="4">Raphael<br>
				<h2>Who's the coolest?</h2>
				<input type="radio" name="surveyChoice4" value="1">Iron Man<br>
				<input type="radio" name="surveyChoice4" value="2">Spiderman<br>
				<input type="radio" name="surveyChoice4" value="3">Flash<br>
				<input type="radio" name="surveyChoice4" value="4">Raphael<br>
				<input type="submit">
				<button>See Results</button>
			</form>
		</div>
	</div>
</body>
</html>