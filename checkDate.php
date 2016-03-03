<?php
/**
 * Created by PhpStorm.
 * User: Justin
 * Date: 4/5/2015
 * Time: 12:30 PM
 */

function checkIfDateExistsDB($month, $day, $year)
{
    $result = mysql_query("SELECT * FROM dates WHERE day = '$day' AND month = '$month' AND year = '$year' LIMIT 1");
    if (mysql_fetch_array($result) !== false)
        return true;
    return false;
}

$day = intval($_GET['day']);
$month = intval($_GET['month']);
$year = intval($_GET['year']);

// without quotes on months
$dateExists = checkIfDateExistsDB($month, $day, $year);

if (!$dateExists) {
    $sql = "INSERT INTO dates(month,day,year) VALUES($month,$day,$year)";
    if (!mysql_query($sql)) {
        die('Error: ' . mysql_error());
    }
    echo 1;
}
echo 0;