<?php
/**
 * Created by PhpStorm.
 * User: Justin
 * Date: 4/5/2015
 * Time: 3:00 PM
 */

date_default_timezone_set('EST');



$DB_NAME = 'sweagle';

 define('DB_USER','root');
 define('DB_PASSWORD','');
 define('DB_HOST','localhost');

$link = mysql_connect(DB_HOST,DB_USER,DB_PASSWORD);
if(!$link){
    die('Could not connect: ' . mysql_error());
}
$db_selected = mysql_select_db($DB_NAME,$link);
if(!$db_selected){
    die("Can't use" . $DB_NAME . ":" . mysql_error());
}

$username = $_GET['username'];
$password = $_GET['password'];


$sql = "SELECT Count(*) AS counter FROM user WHERE email='$username' AND password='$password'";
$sqlUIN = "SELECT UIN FROM user WHERE email='$username' AND password='$password'";

$result = mysql_query($sql);
$resultUIN = mysql_query($sqlUIN);

$values = mysql_fetch_array($resultUIN);
$uin;
$uin = $values[0];


if(!$result || !$resultUIN){
    die('Error: '.mysql_error());
}

$arr = mysql_fetch_array($result);

$success = $arr['counter'];

if($success) {
    session_start();
    $_SESSION['loggedIn'] = true;
    $_SESSION['suin'] = $uin;
    echo 1;
    echo ",";
    echo $uin;
}else{
    // failure
     echo 0;
}


