<?php

define('DB_NAME', 'sweagle');
define('DB_USER', 'root');
define('DB_PASSWORD', '');
define('DB_HOST', 'localhost');

$link = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD);
if (!$link) {
    die('Could not connect: ' . mysql_error());
}
$db_selected = mysql_select_db(DB_NAME, $link);
if (!$db_selected) {
    die("Can't use" . DB_NAME . ":" . mysql_error());
}

// Get UIN
$email = $_REQUEST["q"];

//Check if UIN already exists in DB_HOST
$sql ="SELECT * FROM user WHERE email = '$email' LIMIT 1";
$result = mysql_query($sql);
if (mysql_fetch_array($result) !== false){
        echo "E";
}else{
		echo "DNE";
}
	


mysql_close();

?>