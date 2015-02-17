<?php
/*
 * This is the Controler in the MVC pattern.
 */
// Get access to the session
if (!isset($_SESSION)) {
	session_start();
}

// This variable will be used 
$message = "";
// Get access to the model
include 'model.php';
// Get access to the custom functions library
include 'library/functions.php';

// Bring in the View of the MVC pattern
// Check to see if user has already logged in
if (!isset($_SESSION['loggedin'])) {
	// If they haven't logged in then pullup login screen
	
	// Check if user submitted login info
	if (isset($_POST['submited']) && $_POST['submited'] == 'Login') {
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
	// Check if user wants to register
	} else if (isset($_GET['name']) && $_GET['name'] == 'r') {
		include 'register.php';
	// Check if Registeration Form has been submited
	} else if (isset($_POST['submited']) && $_POST['submited'] == 'Register') {
		// Add new user to database
		echo registerUser();
		include 'login.php';

	// If none of the above then user gets login page
	} else {
		include 'login.php';
	}
// If not the above then user is already logged in so show home page
} else {
	include 'home.php';
}

?>