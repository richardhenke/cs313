<?php
/*
 * This is the Controler in the MVC pattern.
 */
// Get access to the session
if (!isset($_SESSION)) {
	session_start();
}

// This variable will be used to display information about submissions or data changes
$message = "";
// Get access to the model
include 'model.php';
// Get access to the custom functions library
include 'library/functions.php';

// Bring in the View of the MVC pattern
// Check to see if user has already logged in
if (!isset($_SESSION['loggedin'])) {
	// If they haven't logged in then pull up login screen
	header("Location: login.php");
	die();
} else {
	// They are logged in and are directed to home page
	header("Location: home.php");
	die();
}

?>