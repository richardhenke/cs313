<?php 

function loadDatabase()
{
	$dbHost = "localhost";
  //$dbPort = "3306";
	$dbUser = "test_user";
	$dbPassword = "Z35Zxz37mzUeMhRP";
	$dbName = "Scriptures";

	try {
		$connTest = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUser, $dbPassword);
	} catch (PDOException $exc) {
		echo "Sorry the connection could not be established";
	}

	if (is_object($connTest)) {
		return $connTest;
	} else {
		echo ' It failed';
	}
	return $connTest;
}

// This will retrieve scriptures from the database
function getScriptures($id) {
	$conn = loadDatabase();

	try {
		$sql = "SELECT * FROM Scriptures";  
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

function getTopics() {
	$conn = loadDatabase();

	try {
		$sql = "SELECT * FROM Topics";  
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

// This will retrieve scriptures from the database
function insertScriptures() {
	$conn = loadDatabase();

	try {
		$sql = "INSERT INTO Scriptures(book, chapter, verse, content) VALUES (:book, :chapter, :verse, :content)";  
		$stmt = $conn->prepare($sql);
		$stmt->bindValue(':book', $_POST['book'], PDO::PARAM_STR);
		$stmt->bindValue(':chapter', $_POST['chapter'], PDO::PARAM_STR);
		$stmt->bindValue(':verse', $_POST['verse'], PDO::PARAM_STR);
		$stmt->bindValue(':content', $_POST['content'], PDO::PARAM_STR);
		$stmt->execute();
		$data = $stmt->fetchAll();
		$data = $stmt->rowCount();      
		$stmt->closeCursor();      
	} catch (PDOException $ex) {
		$message = 'PDO error in model.';
	}

   // $data will return either a 1 or a 0
	if ($data) {
		return TRUE;
	} else {
		return FALSE;
	}
}
?>