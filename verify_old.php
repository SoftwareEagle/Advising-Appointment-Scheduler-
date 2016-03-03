<?php
/**
 * Created by PhpStorm.
 * User: Justin
 * Date: 4/11/2015
 * Time: 4:00 PM
 */

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

$fname = $_POST['firstName'];
$lname = $_POST['lastName'];
$uin = $_POST['uin'];
$password = $_POST['pass'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$major = $_POST['majors'];

echo $fname.'<br>';
echo $lname.'<br>';
echo $uin.'<br>';
echo $password.'<br>';
echo $email.'<br>';
echo $phone.'<br>';
echo $major.'<br>';

