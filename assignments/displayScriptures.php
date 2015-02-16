<?php
include 'scriptures_functions.php';

$test = getScriptures(1);
echo "<h1>Team Faith</h1>";
foreach ($test as $key => $value) {
	echo "<strong> " . $value['book'] . " " . $value['chapter'] . ":" . $value['verse'] . "</strong>" . "-" . $value['content'] . "<br /><br />";
}

insertScriptures();

?>