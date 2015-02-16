<?php
function connectDb()
{
	// LOCAL ONLY
	//$dbHost = "localhost";
	//$dbUser = "cs313_admin";
	// For web
	$dbHost = "127.12.98.2";
	$dbUser = "cs313_admin";
	$dbPassword = "Z35Zxz37mzUeMhRP";
	$dbName = "who_borrowed_what";
	$connTest = "";

	try {
		$connTest = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUser, $dbPassword);
	} catch (PDOException $exc) {
		echo "Sorry the connection could not be established";
	}

	if (is_object($connTest)) {
		return $connTest;
	} else {
		$errorMessage = "There was an error with the database.";
	}
	return $connTest;
}

function login($email, $password) {
	$sanEmail = validateEmail($email);
	if(doesUserExist($sanEmail)) {
		$userInfo = userLogin($sanEmail, $password);
		if ($userInfo == 0) {
			echo "Oops! There was a problem connecting to the database.";
		} elseif ($userInfo == FALSE) {
			echo "Plese check your login information and try again.";
		} else {
			return $userInfo;
		}
	} else {
		echo "Plese check your login information and try again.";
	}

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
	if (0 !== stcp($password, $confirmPassword)) {
		return false;
	} else {
		return true;
	}

}

function personalizedWelcome() {
	echo "<span class='personal_profile_pic'><img src='" . $_SESSION['profile_picture'] . "'/></span>";
	echo "<span class='personal_name'>$_SESSION[name_first]</span>";
	echo "<span class='logout'><a href='logout.php'>Logout</a></span>";
}

function imageUpload() {
	$target_dir = "pictures/items/";
	$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
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
	if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
		&& $imageFileType != "gif" ) {
		$message = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
	$uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
	$message = "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
	if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
		$message = "The file " . basename( $_FILES["fileToUpload"]["name"]) . " has been uploaded.";
	} else {
		$message = "Sorry, there was an error uploading your file.";
	}
}
return $message;
}

?>