<?php 
function login($username, $password) {
	if(doesUserExist($username)) {
		$userInfo = userLogin($username, $password);
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

function doesUserExist($username) {
	$conn = connectDb();
	try {
// Select the user ID that matches the email
		$sql = "SELECT username FROM user WHERE username = :username";

		$stmt = $conn->prepare($sql);
		$stmt->bindValue(':username', $username, PDO::PARAM_STR);
		$stmt->execute();
		$loginInfo = $stmt->fetch();
		$stmt->closeCursor();
	} catch (PDOException $e) {
      return 0; // indicates failure
  }

   // Find out if you got results
  if (is_array($loginInfo)) {
      return 1; // Indicates user exists
  } else {
      return 0; // Indicates user does NOT exist
  }

}

function userLogin($username, $password) {
   $conn = connectDb(); // The server connection

   // Hash password so it matches
   //$passwordHashed = hashPassword($password);
   try {
// Select the user ID that matches the username and password
   	$sql = "SELECT user_id FROM user
   	WHERE username = :username
   	AND password = :password";

   	$stmt = $conn->prepare($sql);
   	$stmt->bindValue(':password', $password, PDO::PARAM_STR);
   	$stmt->bindValue(':username', $username, PDO::PARAM_STR);
   	$stmt->execute();
   	$loginInfo = $stmt->fetchAll();
   	$stmt->closeCursor();
   } catch (PDOException $e) {
      return 0; // indicates failure
  }

   // Find out if you got results
  if (is_array($loginInfo)) {
  	return $loginInfo;
  } else {
  	return FALSE;
  }

// End of function
}

function connectDb()
{
	// LOCAL ONLY
	$dbHost = "localhost";
	$dbUser = "cs313_admin";
	// For web
	//$dbHost = "127.12.98.2";
	//$dbUser = "cs313_admin";
	$dbPassword = "Z35Zxz37mzUeMhRP";
	$dbName = "hash_test";
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

if ($_POST['submited'] == 'Register') {
	echo "Yesy submitted";
	$conn = $connectDb();

	$sql = "INSERT INTO user(username, password) VALUES (:username, :password)";
	$stmt = $conn->prepare($sql);
	$stmt->bindValue(':username', $_POST['username'], PDO::PARAM_STR);
	$stmt->bindValue(':password', $_POST['password'], PDO::PARAM_STR);
	$result = $stmt->execute();
	$stmt->closeCursor();
}

?>

<!DOCTYPE html>
<!-- This is the View in the MVC pattern -->
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Password Hash | Home</title>
</head>
<body>
	<h1>Welcome!</h1>
	<?php

	//login($_POST['username'], $_POST['password']);

	?>

</body>
</html>