<?php
function connectDb()
{

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

function imageUpload() {
	echo "<br>This is where my file is saving: ".sys_get_temp_dir()."<br>";
	echo "<br>OPENSHIFT DIR: ".$OPENSHIFT_DATA_DIR."<br>";
	//$target_dir = "pictures/items/";
	$target_dir = $OPENSHIFT_DATA_DIR;
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

?>