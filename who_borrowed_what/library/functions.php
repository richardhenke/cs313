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
}

// This one works! 2/18/15 at 1:30am
function imageUpload() {
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

	try {
		// Check if image file is a actual image or fake image
		if(isset($_POST["upload"])) {
			$check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
			if($check !== false) {
				$_SESSION['message'] = "File is an image - " . $check["mime"] . ".";
				$uploadOk = 1;
			} else {
				$uploadOk = 0;
				throw new Exception("File is not an image.");
			}
		}
// Check if file already exists
		if (file_exists($target_file)) {
			$uploadOk = 0;
			throw new Exception("Sorry, file already exists.");
		}
// Check file size
		$size = 500000;
		if ($_FILES["fileToUpload"]["size"] > $size) {
			$uploadOk = 0;
			throw new Exception("Sorry, your file is too large. It must be less than: $size Kb");
		}
// Allow certain file formats
		if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
			$uploadOk = 0;
			throw new Exception("Sorry, only JPG, JPEG, PNG & GIF files are allowed.");
		}
// Check if $uploadOk is set to 0 by an error
		if ($uploadOk == 0) {
			throw new Exception("Sorry, your file was not uploaded.");
// if everything is ok, try to upload file
		} else {
			if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
				throw new Exception("The image " . '"' . $_FILES["fileToUpload"]["name"] . '"' . " has been uploaded.");
			} else {
				throw new Exception("Sorry, there was an error uploading your file.");
			}
		}
	} catch (Exception $e) {
		$_SESSION['message'] = $e->getMessage();
	}

	return $uploadOk;
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
	unset($_SESSION['message']);
}

function displayBorrowedTransaction($value) {
	$created = date( 'F d, Y', strtotime($value['date_created']));
	$return = $value['return_date'];
	if ($return == '0000-00-00') {
		$return = "Not Specified";
	} else {
		$return = date( 'F d, Y', strtotime($value['return_date']));
	}
	echo "<div class='transaction'><div class='trans_left'>";
	echo "<img class='trans_item_picture' src='" . $value['item_picture'] . "' />";
	echo "<span class='trans_item_name'>". $value['name'] . "</span>";
	echo "<div class='trans_details'>";
	echo "<span class='trans_date_created'>Borrowed on: " . date( 'F d, Y', strtotime($value['date_created'])) . "</span>";
	echo "<span class='trans_return_date'>Return by: " . date( 'F d, Y', strtotime($value['return_date'])) . "</span>";
	echo "</div></div>";
	echo "<div class='trans_middle'>";
	echo "<span class='to_or_from'>From</span>";
	echo "</div>";         
	echo "<div class='trans_right'> <img class='trans_user_picture' src='" . $value['profile_picture'] . "' /><span class='trans_user_name'>" . $value['name_first'] . " " . $value['name_last'] . "</span>";
	echo "<div class='trans_details'>";
	echo "</div>";
	echo "</div>";
	echo "</div>";
}

function displayLentTransaction($value) {
	$created = date( 'F d, Y', strtotime($value['date_created']));
	$return = $value['return_date'];
	if ($return == '0000-00-00') {
		$return = "Not Specified";
	} else {
		$return = date( 'F d, Y', strtotime($value['return_date']));
	}
	echo "<div class='transaction'><div class='trans_left'>";
	echo "<img class='trans_item_picture' src='" . $value['item_picture'] . "' />";
	echo "<span class='trans_item_name'>". $value['name'] . "</span>";
	echo "<div class='trans_details'>";
	echo "<span class='trans_date_created'>Borrowed on: " . $created . "</span>";
	echo "<span class='trans_return_date'>Return by: " . $return . "</span>";
	echo "</div></div>";
	echo "<div class='trans_middle'>";
	echo "<span class='to_or_from'>To</span>";
	if ($value['active'] != "NO") {
		echo "<span class='trans_complete custom_button'><a href='?name=ct&value=$value[transaction_id]'>Complete</a></span>";
	}
	echo "</div>";         
	echo "<div class='trans_right'> <img class='trans_user_picture' src='" . $value['profile_picture'] . "' /><span class='trans_user_name'>" . $value['name_first'] . " " . $value['name_last'] . "</span>";
	echo "</div>";
	echo "</div>";
}

?>