<?php
function connectDb()
{
	// LOCAL ONLY
	//$dbHost = "localhost";
	//$dbUser = "cs313_admin";

	$dbHost = "127.12.98.2";
	$dbUser = "adminHLIkN1p";
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


function getTransactionsBorrowed() {
	// 1) Query transactions
    // Change this to use session variable for user id
	$user = 1;
	$borrowedTrans = queryBorrowedTransactions($user);
	echo "<br />Results for transactions:  <br />". var_dump($borrowedTrans) ."<br />";
	//    a) Based on query results query owner info
	//    b) Based on query results query borrowers info

	// 2) Query items that were borrowed
	//    a) Get item NAME, PHOTO

	// Return an array of arrays in this form
	// Array {
	//   [Trans#0][Item_name][Item_photo][borrower_name_f][borrower_name_l][borrower_photo][trans_create_date][return_date]
    //   [Trans#1][Item_name][Item_photo][borrower_name_f][borrower_name_l][borrower_photo][trans_create_date][return_date]
    //   .
    //   .
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

function personalizedWelcom() {
	echo "<span class='personal_profile_pic'><img src='" . $_SESSION['profile_picture'] . "'/></span>";
	echo "<span class='personal_name'>$_SESSION[name_first]</span>";
	
}

?>