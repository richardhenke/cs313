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

  $db = new PDO("mysql:host=$dbHost:$dbPort;dbname=$dbName", $dbUser, $dbPassword);

  return $db;
}
echo "<br>Loading database<br>";
// connects to the test database
function testConnection() {
   $server = '127.12.98.2:3306';
   $username = 'cs313_admin';
   $password = '6zDvAGqz2u4UFWww';
   $database = 'who_borrowed_what';
   $dsn = "mysql:host=$server;dbname=$database";
   try {
      $connTest = new PDO($dsn, $username, $password);
   } catch (PDOException $exc) {
      echo "Sorry the connection could not be established";
   }

   if (is_object($connTest)) {
      return $connTest;
   } else {
      echo 'It failed';
   }
}

$conn = testConnection();
echo "<br>did it load?<br>";

?>