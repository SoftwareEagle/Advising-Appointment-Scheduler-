<?php
/**
 * Created by PhpStorm.
 * Author: Justin Gosselin, Reza Ansary
 * Modified by : Reza Ansary
 * Date: 4/17/2015
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
require 'PHPMailerAutoload.php';

$fname = $_POST['firstName'];
$lname = $_POST['lastName'];
$uin = $_POST['uin'];
$password = $_POST['pass'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$major = $_POST['majors'];

if($major=="other"){
	$major = $_POST['otherMajor'];
}


$sql = "INSERT INTO user(fname,lname,UIN,password,email,phonenumber,major) VALUES('$fname','$lname','$uin','$password','$email','$phone','$major')";

if(!mysql_query($sql)){
	die('Error'.mysql_error());
}else{	
	$mail = new PHPMailer;

	$mail->isSMTP();                                    
	$mail->Host = 'smtp.gmail.com'; 
	//$mail->SMTPDebug=1;
	$mail->SMTPAuth = true;                               
	$mail->Username = 'sweagle2015@gmail.com';  // for testing purposes only!                          
	$mail->Password = 'sweagle9545';                        
	$mail->SMTPSecure = 'tls'; 
	$mail->Port = 587;                

	$mail->From = 'sweagle2015@gmail.com';
	$mail->FromName = 'Engineering Advising'; 
	$mail->addAddress($email);   
	
	$mail->WordWrap = 50;                                
	$mail->isHTML(true);                                  
	 
	$mail->Subject = 'Account created successfully!';
	$mail->Body  = 'Hello, This is from FGCU Engineering Advising. You have created your account successfully! Here is the information you have provided during account creation: ';
	$mail->Body .= '<br> Your first name is: '.$fname.',';
	$mail->Body .= '<br> last name is: '.$lname.',';
	$mail->Body .= '<br> your UIN is: '.$uin.',';
	$mail->Body .= '<br> your password is: '.$password.',';
	$mail->Body .= '<br> your email is: '.$email.',';
	$mail->Body .= '<br> your phone number is: '.$phone.',';
	$mail->Body .= '<br> your major is: '.$major.'.';
	 
	if(!$mail->send()) {
	   echo 'Message could not be sent.';
	   echo 'Mailer Error: ' . $mail->ErrorInfo;
	   exit;
	}
	
	header("Location: default.php"); // redirect using da PHP 
	die();
	//echo '<br><a href="default.php">Click here to return the homepage.</a>';
}



mysql_close();

