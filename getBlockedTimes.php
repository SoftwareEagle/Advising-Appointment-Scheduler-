<?php
date_default_timezone_set('EST');

 	define('DB_NAME','sweagle');
	define('DB_USER','root');
	define('DB_PASSWORD','');
	define('DB_HOST','localhost');
	
	$link = mysql_connect(DB_HOST,DB_USER,DB_PASSWORD);
	if(!$link){
		die('Could not connect: ' . mysql_error());
	}
	$db_selected = mysql_select_db(DB_NAME,$link);
	if(!$db_selected){
		die("Can't use" . DB_NAME . ":" . mysql_error());
	}
	

function getBlockedTimes($month, $day, $year) {
	$link = mysql_connect(DB_HOST,DB_USER,DB_PASSWORD);
	  if(!$link){
		  die('Could not connect: ' . mysql_error());
	   }
	   $db_selected = mysql_select_db(DB_NAME,$link);
	   if(!$db_selected){
		  die("Can't use" . DB_NAME . ":" . mysql_error());
	   }
    $sql = "SELECT blocked_times FROM times JOIN dates ON dates.id = times.id WHERE dates.day = '$day' AND dates.month = '$month' AND dates.year = '$year'";
    $result = mysql_query($sql);
	//$values = mysql_fetch_array($sql);
	
	$row = mysql_fetch_array($result,MYSQL_NUM);
	mysql_close();
	return $row[0];

}

function checkIfDateExistsDB($month, $day, $year)
{
    $result = mysql_query("SELECT * FROM dates WHERE day = '$day' AND month = '$month' AND year = '$year' LIMIT 1");
    if (mysql_fetch_array($result) !== false)
        return true;
    return false;
}

function startsWith($haystack, $needle) {
    // search backwards starting from haystack length characters from the end
    return $needle === "" || strrpos($haystack, $needle, -strlen($haystack)) !== FALSE;
	}
function endsWith($haystack, $needle) {
    // search forward starting from end minus needle length characters
    return $needle === "" || (($temp = strlen($haystack) - strlen($needle)) >= 0 && strpos($haystack, $needle, $temp) !== FALSE);
}


	$day = intval($_GET['day']);
	$month = intval($_GET['month']);
	$year = intval($_GET['year']);

    $dateExists = checkIfDateExistsDB($month, $day, $year);

    if (!$dateExists) {
        $sql = "INSERT INTO dates(month,day,year) VALUES($month,$day,$year)";
        if (!mysql_query($sql)) {
            die('Error: ' . mysql_error());
        }

        $result = mysql_query("SELECT id FROM dates WHERE day = '$day' AND month = '$month' AND year = '$year' LIMIT 1");

        $id = mysql_fetch_array($result,MYSQL_NUM);

        $sql = "INSERT INTO times(id,blocked_times) VALUES($id[0],'')";

        if (!mysql_query($sql)) {
            die('Error: ' . mysql_error());
        }




    }


	echo getBlockedTimes($month, $day, $year);
