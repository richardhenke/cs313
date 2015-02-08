<?php 
/*
 *  This is the Model in the MVC pattern: This will talk to the database.
 */

// This will retrieve users from the database
function getUsers() {
	$conn = connectDb();

	try {
		$sql = "SELECT * FROM user";  
		$stmt = $conn->prepare($sql);
		$stmt->execute();
		$data = $stmt->fetchAll();
		$stmt->closeCursor();
	} catch (PDOException $ex) {
		echo 'PDO error in model.';
	}

	if (is_array($data)) {
		return $data;
	} else {
		return FALSE;
	}
}

function getBorrowedTransactions($user_id) {
	$conn = connectDb();

	try {
		// This returns the number of rows to enter into next query
		$sql = "SELECT u.name_first, u.name_last,  a.profile_picture, i.name, i.item_picture, t.date_created, t.return_date
		FROM item i 
		INNER JOIN transaction t 
		ON t.owner_id = $user_id 
		INNER JOIN user u 
		INNER JOIN account a
		ON u.user_id = t.borrower_id 
		AND t.active = 'YES'
		AND a.user_id = t.borrower_id
		AND i.item_id = t.item_id;";
		$stmt = $conn->prepare($sql);
		$stmt->execute();
		$data = $stmt->fetchAll();
		$stmt->closeCursor();
	} catch (PDOException $ex) {
		echo 'PDO error in model.';
	}
	if (is_array($data)) {
		return $data;
	} else {
		return FALSE;
	}
}

function doesUserExist($email) {
   $conn = connectDb(); // The server connection

   try {
// Select the user ID that matches the email
   	$sql = "SELECT email FROM user WHERE email = :email";

   	$stmt = $conn->prepare($sql);
   	$stmt->bindValue(':email', $email, PDO::PARAM_STR);
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

function userLogin($email, $password) {
   $conn = connectDb(); // The server connection

   // Hash password so it matches
   //$passwordHashed = hashPassword($password);
   try {
// Select the user ID that matches the email and password
   	$sql = "SELECT u.user_id, u.name_first, u.name_last, u.email, u.phone_number, a.profile_picture FROM user u JOIN account a
   	WHERE u.email = :email
   	AND u.user_id = a.user_id
   	AND a.password = :password";

   	$stmt = $conn->prepare($sql);
   	$stmt->bindValue(':password', $password, PDO::PARAM_STR);
   	$stmt->bindValue(':email', $email, PDO::PARAM_STR);
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


?>