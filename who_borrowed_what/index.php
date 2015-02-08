<?php
/*
 * This is the Controler in the MVC pattern.
 */
// Get access to the session
if (!isset($_SESSION)) {
	session_start();
}
// Get access to the model
include 'model.php';
// Get access to the custom functions library
include 'library/functions.php';

// Bring in the View of the MVC pattern
// Check to see if user has already logged in
if (!isset($_SESSION['loggedin'])) {
	// If they haven't logged in then pullup login screen
	
	// Check if user submitted login info
	if (!empty($_POST['email'])) {
		//include 'home.php';
		//$_SESSION['loggedin'] = "TRUE";

		$userInfo = login($_POST['email'], $_POST['password']);
		if (is_array($userInfo)) {
			foreach ($userInfo as $key => $value) {
				$_SESSION['user_id'] = $value['user_id'];
				$_SESSION['name_first'] = $value['name_first'];
				$_SESSION['name_last'] = $value['name_last'];
				$_SESSION['phone_number'] = $value['phone_number'];
				$_SESSION['email'] = $value['email'];
				$_SESSION['profile_picture'] = $value['profile_picture'];
				$_SESSION['loggedin'] = "TRUE";
			}
			include 'home.php';
		}
	} else {
		include 'login.php';
	}
} else {
	include 'home.php';
}

?>