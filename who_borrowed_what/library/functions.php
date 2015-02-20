<?php
function connectDb()
{
	$message = "";
	$openShiftVar = getenv('OPENSHIFT_MYSQL_DB_HOST');

	if ($openShiftVar === null || $openShiftVar == "")
	{
     		// LOCAL ONLY
		$dbHost = "localhost";
		$dbUser = "cs313_admin";

	} else {
    // For web
		$dbHost = "127.12.98.2";
		$dbUser = "cs313_admin";
	}

	$dbPassword = "Z35Zxz37mzUeMhRP";
	$dbName = "who_borrowed_what";
	$connTest = "";

	try {
		$connTest = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUser, $dbPassword);
	} catch (PDOException $exc) {
		$message = "Sorry the connection could not be established";
	}

	if (is_object($connTest)) {
		return $connTest;
	} else {
		$message = "There was an error with the database.";
	}
	return $message;
}

function login($email, $password) {
	$message = "";
	$sanEmail = validateEmail($email);
	if(doesUserExist($sanEmail)) {
		$userInfo = userLogin($sanEmail, $password);
		if ($userInfo == 0) {
			$message = "Oops! There was a problem connecting to the database.";
		} elseif ($userInfo == FALSE) {
			$message = "Plese check your login information and try again.";
		} else {
			return $userInfo;
		}
	} else {
		$message = "Plese check your login information and try again.";
	}
	return $message;
}
// Validates a string and strips extra characters
function validateString($string) {
	$string = filter_var($string, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW);
	return $string;
}

// Validates and Sanitaizes an email address
function validateEmail($email) {
	$email = filter_var($email, FILTER_SANITIZE_EMAIL);
	$email = filter_var($email, FILTER_VALIDATE_EMAIL);
	return $email;
}

// Validate password
function validateMatchingPassword($password, $confirmPassword) {
	if ($password == $confirmPassword) {
		return true;
	} else {
		return false;
	}
}

// Hash a password
function hashPassword($password) {
	return crypt($password, '$5$rounds=5000$yabad507abadoori$');
}

// Validates dates
function validateDate($date) {
	if (0 === preg_match("/^(\d\d\d\d)-(\d\d)-(\d\d)$/", $date)) {
		return true;
	} else {
		return false;
	}
}

function personalizedWelcome() {
	echo "<span class='personal_profile_pic'><img src='" . $_SESSION['profile_picture'] . "'/></span>";
	echo "<span class='personal_name'>$_SESSION[name_first]</span>";
	echo "<span class='logout'><a href='logout.php'>Logout</a></span>";
}

// This one works! 2/18/15 at 1:30am
function imageUpload() {
	$message = "";
	$target_dir = "pictures/items/";
	$itemNumber = getItemNumber();
	$num = $itemNumber[0][0];
	$num++;
	$ext = pathinfo($_FILES["fileToUpload"]["name"], PATHINFO_EXTENSION);
	$newFilename = "item" . $num . "." . $ext;
	$target_file = $target_dir . $newFilename;	
	$_SESSION['item_picture'] = $target_file;
	$uploadOk = 1;
	$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
// Check if image file is a actual image or fake image
	if(isset($_POST["upload"])) {
		$check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
		if($check !== false) {
			$message = "File is an image - " . $check["mime"] . ".";
			$uploadOk = 1;
		} else {
			$message = "File is not an image.";
			$uploadOk = 0;
		}
	}
// Check if file already exists
	if (file_exists($target_file)) {
		$message = "Sorry, file already exists.";
		$uploadOk = 0;
	}
// Check file size
	if ($_FILES["fileToUpload"]["size"] > 500000) {
		$message = "Sorry, your file is too large.";
		$uploadOk = 0;
	}
// Allow certain file formats
	if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
		$message = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
		$uploadOk = 0;
	}
// Check if $uploadOk is set to 0 by an error
	if ($uploadOk == 0) {
		$message = "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
	} else {
		if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
			$message = "The file " . $newFilename . " has been uploaded.";
		} else {
			$message = "Sorry, there was an error uploading your file.";
		}
	}
	return $message;
}

function registerUser() {
	$password = $_POST['password'];
	$confirmPassword = $_POST['password_confirm'];
	if (validateMatchingPassword($password, $confirmPassword)) {
		$result = addUser($password);
		if ($result) {
			$message = "You are now Registered!";
		} else {
			$message = "Registration faild.";
		}		
	} else {
		$message = "Passwords do not match.";
	}
	return $message;
}

function displayMessage($message) {
	echo "<p class='message'> $message </p>";
}

function displayTransaction($value) {
	echo "<div class='transaction'><div class='trans_left'>";
	echo "<img class='trans_item_picture' src='" . $value['item_picture'] . "' /><span class='trans_item_name'>". $value['name'] . "</span></div>";
	echo "<div class='trans_middle'>";
	echo "<span class='to_or_from'>From</span>";
	echo "</div>";         
	echo "<div class='trans_right'> <img class='trans_user_picture' src='" . $value['profile_picture'] . "' /><span class='trans_user_name'>" . $value['name_first'] . " " . $value['name_last'] . "</span></div>";
	echo "</div>";
}

?>