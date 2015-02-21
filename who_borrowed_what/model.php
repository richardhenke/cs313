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

//  1 to return active
//  0 for not active
// -1 all tansactions
function getLentTransactions($user_id, $active) {
	if ($active == 1) {
		$active = "AND t.active = 'YES'";
	} else if ($active == 0) {
		$active = "AND t.active = 'NO'";
	} else {
		$active = '';
	}

	$conn = connectDb();

	try {
		$sql = "SELECT u.name_first, u.name_last,  a.profile_picture, i.name, i.item_picture, t.date_created, t.return_date, t.transaction_id, t.active
		FROM item i 
		INNER JOIN transaction t 
		ON t.owner_id = $user_id 
		INNER JOIN user u 
		INNER JOIN account a
		ON u.user_id = t.borrower_id 
		$active
		AND a.user_id = t.borrower_id
		AND i.item_id = t.item_id
		ORDER BY (t.transaction_id AND t.active) DESC";
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

//  1 to return active
//  0 for not active
// -1 all tansactions
function getBorrowedTransactions($user_id, $active) {
	if ($active == 1) {
		$active = "AND t.active = 'YES'";
	} else if ($active == 0) {
		$active = "AND t.active = 'NO'";
	} else {
		$active = '';
	}

	$conn = connectDb();

	try {
		$sql = "SELECT u.name_first, u.name_last,  a.profile_picture, i.name, i.item_picture, t.date_created, t.return_date, t.transaction_id
		FROM item i 
		INNER JOIN transaction t 
		ON t.borrower_id = $user_id
		INNER JOIN user u 
		INNER JOIN account a
		ON u.user_id = t.owner_id 
		$active
		AND a.user_id = t.owner_id
		AND i.item_id = t.item_id
		ORDER BY (t.transaction_id AND t.active) DESC";
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
	$gateCheck = TRUE;
} else {
	$gateCheck = FALSE;
}

} else {
	$stmt->closeCursor();
	$gateCheck = FALSE;
}
return $gateCheck;
}

// NOTE: The roll back function does not work here!!! fix later...
function addUser($password) {
	$conn = connectDb();
	$message = "";
	$result = "";
	$gateCheck = "";

	try {
		$conn->beginTransaction();
		echo "<br>We are beginning the transaction...<br>";

		$sql = "INSERT INTO user(date_created, last_updated, name_first, name_last, email, phone_number) 
		VALUES (:date_created, :last_updated, :name_first, :name_last, :email, :phone_number)";

		$stmt = $conn->prepare($sql);
		$stmt->bindValue(':date_created', date("Y-m-d"), PDO::PARAM_STR);
		$stmt->bindValue(':last_updated', date("Y-m-d"), PDO::PARAM_STR);
		$stmt->bindValue(':name_first', $_POST['name_first'], PDO::PARAM_STR);
		$stmt->bindValue(':name_last', $_POST['name_last'], PDO::PARAM_STR);
		$stmt->bindValue(':email', $_POST['email'], PDO::PARAM_STR);
		$stmt->bindValue(':phone_number', $_POST['phone_number'], PDO::PARAM_STR);
		$result = $stmt->execute();
		$new_id = $conn->lastInsertId();
		if (!$result) {
			throw new Exception($conn->error);
		}

	// $result =  1 - indicates true
	// $result =  0 - indicates false
	// $result = -1 - indicates an error

		// $sql = "INSERT INTO account(user_id, username, password, date_created, last_updated, profile_picture, profile_description)
		// VALUES ($new_id, :username, :password, :date_created, :last_updated, 'pictures/profile_pictures/generic_profile.png', 'No description has been entered by $_POST[name_first] yet...')";
		$sql = "INSERT INTO account 
		(	user_id            
			, username           
			, password           
			, date_created       
			, last_updated       
			, last_updated_by    
			, profile_picture    
			, profile_description
			, account_type
			) values 
( $new_id
	, :username
	, :password
	, :date_created
	, :last_updated
	, 1
	, 'pictures/profile_pictures/generic_profile.png'
	, :profile_description
	, 'user'
	)";

$stmt = $conn->prepare($sql);
$stmt->bindValue(':username', $_POST['email'], PDO::PARAM_STR);
$stmt->bindValue(':password', $password, PDO::PARAM_STR);
$stmt->bindValue(':date_created', date("Y-m-d"), PDO::PARAM_STR);
$stmt->bindValue(':last_updated', date("Y-m-d"), PDO::PARAM_STR);
$stmt->bindValue(':profile_description', $description = 'No description has been entered for ' . $_POST['name_first'] . ' yet.', PDO::PARAM_STR);
$result = $stmt->execute();
$stmt->closeCursor();
if (!$result) {
	throw new Exception($conn->error);
}

     // If we arrive here, it means that no exception was thrown
     // i.e. no query has failed, and we can commit the transaction
$conn->commit();
} catch (Exception $e) {
    // An exception has been thrown
    // We must rollback the transaction
	echo "<br>We had to roll back the transaction...<br>";
	$conn->rollback();
}
}

function getItemNumber() {
   $conn = connectDb(); // The server connection

   // Hash password so it matches
   //$passwordHashed = hashPassword($password);
   try {
// Select the user ID that matches the email and password
   	$sql = "SELECT MAX(item_id) FROM item";
   	$stmt = $conn->prepare($sql);
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

function updateTransaction($transaction_id, $yesOrNo) {
	$conn = connectDb(); // The server connection
	try {
      $sql = "UPDATE transaction SET
              active = :yesOrNo, last_updated = :update_date WHERE transaction_id = :id";
      $stmt = $conn->prepare($sql);
      $stmt->bindValue(':id', $transaction_id, PDO::PARAM_INT);
      $stmt->bindValue(':yesOrNo', $yesOrNo, PDO::PARAM_STR);
      $stmt->bindValue(':update_date', date("Y-m-d"), PDO::PARAM_STR);
      $stmt->execute();
      $stmt->fetchAll();
      $updateResult = $stmt->rowCount();      
      $stmt->closeCursor();      
   } catch (PDOException $ex) {
      $_SESSION['message'] = 'PDO error in model.';
   }
   
   // $updateResult will return either a 1 or a 0
   if ($updateResult) {
      return TRUE;
   } else {
      return FALSE;
   }

// End of function
}



?>