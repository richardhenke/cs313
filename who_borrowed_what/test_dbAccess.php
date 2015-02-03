<?php 

// // Connects to the who_borrowed_what database
// function guitar1Connection() {
//    $server = 'localhost';
//    $username = 'keepitco_iClient';
//    $password = '6zDvAGqz2u4UFWww';
//    $database = 'keepitco_guitar1';
//    $dsn = "mysql:host=$server;dbname=$database";
//    try {
//       $connGuitar1 = new PDO($dsn, $username, $password);
//    } catch (PDOException $exc) {
//       echo "Sorry the connection could not be established";
//    }

//    if (is_object($connGuitar1)) {
//       return $connGuitar1;
//    } else {
//       echo 'It failed';
//    }
// }



// define('DB_HOST', getenv('OPENSHIFT_MYSQL_DB_HOST'));
// define('DB_PORT',getenv('OPENSHIFT_MYSQL_DB_PORT')); 
// define('DB_USER',getenv('OPENSHIFT_MYSQL_DB_USERNAME'));
// define('DB_PASS',getenv('OPENSHIFT_MYSQL_DB_PASSWORD'));
// define('DB_NAME',getenv('OPENSHIFT_GEAR_NAME'));

// $dsn = 'mysql:dbname='.DB_NAME.';host='.DB_HOST.';port='.DB_PORT;
// $dbh = new PDO($dsn, DB_USER, DB_PASS);

// $dbHost = getenv('OPENSHIFT_MYSQL_DB_HOST');
// $dbPort = getenv('OPENSHIFT_MYSQL_DB_PORT');
// $dbUser = getenv('OPENSHIFT_MYSQL_DB_USERNAME');
// $dbPassword = getenv('OPENSHIFT_MYSQL_DB_PASSWORD');

//echo "host:$dbHost:$dbPort <br>dbName:$dbName <br>user:$dbUser <br>password:$dbPassword<br />\n";
function loadDatabase()
{

	$dbHost = "127.12.98.2";
	$dbPort = "3306";
	$dbUser = "cs313_admin";
	$dbPassword = "Z35Zxz37mzUeMhRP";

	$dbName = "who_borrowed_what";

     // $openShiftVar = getenv('OPENSHIFT_MYSQL_DB_HOST');

     // if ($openShiftVar === null || $openShiftVar == "")
     // {
     //      // Not in the openshift environment
     //      //echo "Using local credentials: "; 
     //      require("setLocalDatabaseCredentials.php");
     // }
     // else 
     // { 
     //      // In the openshift environment
     //      //echo "Using openshift credentials: ";

     //      $dbHost = getenv('OPENSHIFT_MYSQL_DB_HOST');
     //      $dbPort = getenv('OPENSHIFT_MYSQL_DB_PORT'); 
     //      $dbUser = getenv('OPENSHIFT_MYSQL_DB_USERNAME');
     //      $dbPassword = getenv('OPENSHIFT_MYSQL_DB_PASSWORD');
     // } 
     //echo "host:$dbHost:$dbPort dbName:$dbName user:$dbUser password:$dbPassword<br >\n";
  //echo "host:$dbHost:$dbPort <br>dbName:$dbName <br>user:$dbUser <br>password:$dbPassword<br />\n";

	// $db = new PDO("mysql:host=$dbHost:$dbPort;dbname=$dbName", $dbUser, $dbPassword);

	try {
		$connTest = new PDO("mysql:host=$dbHost:$dbPort;dbname=$dbName", $dbUser, $dbPassword);
	} catch (PDOException $exc) {
		echo "Sorry the connection could not be established";
	}

	if (is_object($connTest)) {
		echo "<br>It worked!<br>";
		return $connTest;
	} else {
		echo ' It failed';
	}
	return $db;
}

function insert($stuff) {
	$conn = loadDatabase();

	try {
		$sql = "INSERT INTO user (date_created, last_updated, last_updated_by, name_first, name_last, email, phone_number) VALUES (:date1, :date2, :num, :fname, :lname, :email, :phone)";
		$stmt = $conn->prepare($sql);
		$stmt->bindValue(':date1', "0000-00-00", PDO::PARAM_STR);
		$stmt->bindValue(':date2', "0000-00-00", PDO::PARAM_STR);
		$stmt->bindValue(':num', 1, PDO::PARAM_STR);
		$stmt->bindValue(':fname', "richard", PDO::PARAM_STR);
		$stmt->bindValue(':lname', "henke", PDO::PARAM_STR);
		$stmt->bindValue(':email', "rich@rich.com", PDO::PARAM_STR);
		$stmt->bindValue(':phone', "123123123123123", PDO::PARAM_STR);
		$result = $stmt->execute();
		$stmt->closeCursor();
	} catch (PDOException $exc) {
		echo "<br>PDO error insert error.<br>";
	}
// $result =  1 - indicates true
// $result =  0 - indicates false
// $result = -1 - indicates an error
	if ($result) {
		echo "<br>TRUE - result is:$result <br>";
		return TRUE;
	} else {
		echo "<br>FALSE - result is:$result <br>";
		return FALSE;
	}
}

echo "<br>Loading database<br>";
$conn = loadDatabase();
$test = insert("");

echo "<br>did it load? Test: $test<br>";


?>