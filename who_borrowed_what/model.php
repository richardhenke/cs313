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

function getLentTransactions($user_id) {
	$conn = connectDb();

	try {
		$sql = "SELECT u.name_first, u.name_last,  a.profile_picture, i.name, i.item_picture, t.date_created, t.return_date
		FROM item i 
		INNER JOIN transaction t 
		ON t.owner_id = $user_id 
		INNER JOIN user u 
		INNER JOIN account a
		ON u.user_id = t.borrower_id 
		AND t.active = 'YES'
		AND a.user_id = t.borrower_id
		AND i.item_id = t.item_id";
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
		$sql = "SELECT u.name_first, u.name_last,  a.profile_picture, i.name, i.item_picture, t.date_created, t.return_date
		FROM item i 
		INNER JOIN transaction t 
		ON t.borrower_id = $user_id
		INNER JOIN user u 
		INNER JOIN account a
		ON u.user_id = t.owner_id 
		AND t.active = 'YES'
		AND a.user_id = t.owner_id
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

function createTransaction($item_picture) {
	$conn = connectDb();
	$message = "";
	$result = "";
	$gateCheck = "";

	try {
		$sql = "INSERT INTO item(name, date_created, 
			last_updated, tags, description, item_picture) VALUES (:name, 
			:date_created, 
			:last_updated, 
			:tags, :description, 
			:item_picture)";

	$stmt = $conn->prepare($sql);
	$stmt->bindValue(':name', $_POST['item_name'], PDO::PARAM_STR);
	$stmt->bindValue(':date_created', date("Y-m-d"), PDO::PARAM_STR);
	$stmt->bindValue(':last_updated', date("Y-m-d"), PDO::PARAM_STR);
	$stmt->bindValue(':tags', $_POST['tags'], PDO::PARAM_STR);
	$stmt->bindValue(':description', $_POST['description'], PDO::PARAM_STR);
	$stmt->bindValue(':item_picture', $item_picture, PDO::PARAM_STR);
	$result = $stmt->execute();
	$stmt->closeCursor();
	} catch (PDOException $exc) {
		$message = 'PDO error in model.';
	}
	// $result =  1 - indicates true
	// $result =  0 - indicates false
	// $result = -1 - indicates an error
	if ($result) {
		$sql = "INSERT INTO transaction(date_created,
			last_updated, return_date, owner_id, borrower_id, active, item_id) VALUES (:date_created,
			:last_updated, :return_date, :owner_id, :borrower_id, 'YES', LAST_INSERT_ID())";
	$stmt = $conn->prepare($sql);
	$stmt->bindValue(':date_created', date("Y-m-d"), PDO::PARAM_STR);
	$stmt->bindValue(':last_updated', date("Y-m-d"), PDO::PARAM_STR);
	if (isset($_POST['return_date'])) {
		$stmt->bindValue(':return_date', $_POST['return_date'], PDO::PARAM_STR);
	} else {
		$stmt->bindValue(':return_date', "", PDO::PARAM_STR);
	}
	$stmt->bindValue(':owner_id', $_SESSION['user_id'], PDO::PARAM_STR);
	$stmt->bindValue(':borrower_id', $_POST['lendTo'], PDO::PARAM_STR);
	$result = $stmt->execute();
	$stmt->closeCursor();
	if ($result) {
		echo "<br>Look at: #1";
		$gateCheck = TRUE;
	} else {
		echo "<br>Look at: #2";
		$gateCheck = FALSE;
	}

	} else {
		echo "<br>Look at: #3";
		$stmt->closeCursor();
		$gateCheck = FALSE;
	}
	echo "<br>Look at: #4";
	return $gateCheck;
}




?>