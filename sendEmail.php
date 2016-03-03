<?php
/**
 * Created by Notepad++.
 * Author: Reza Ansary
 * Date: 4/18/2015
 * Time: 4:00 PM
 */
define('DB_NAME', 'sweagle');
define('DB_USER', 'root');
define('DB_PASSWORD', '');
define('DB_HOST', 'localhost');

require 'PHPMailerAutoload.php';

$sendTo = $_POST['email'];

$link = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD);
if (!$link) {
    die('Could not connect: ' . mysql_error());
}
$db_selected = mysql_select_db(DB_NAME, $link);
if (!$db_selected) {
    die("Can't use" . DB_NAME . ":" . mysql_error());
}

$sqlPassword = "SELECT password FROM user WHERE email='".$sendTo."';";

if(!mysql_query($sqlPassword)){
	die('Error'.mysql_error());
}else{	
	$mail = new PHPMailer;

	$result = mysql_query($sqlPassword);
	$values = mysql_fetch_array($result);
	
	$password = $values[0];

	$mail->isSMTP();                                    
	$mail->Host = 'smtp.gmail.com'; 
	//$mail->SMTPDebug=1;
	$mail->SMTPAuth = true;                               
	$mail->Username = 'sweagle2015@gmail.com';  // for testing purposes only!                          
	$mail->Password = 'sweagle9545';                        
	$mail->SMTPSecure = 'tls'; 
	$mail->Port = 587;                           
	 
	$mail->From = 'sweagle2015@gmail.com';
	$mail->FromName = 'Rachel Boyce - Engineering Advising';
	$mail->addAddress($sendTo);  
	 
	//$mail->addReplyTo('reza7634@gmail.com', 'reza 9565 t');
	 
	$mail->WordWrap = 50;                                
	$mail->isHTML(true);                                  
	 
	$mail->Subject = 'Engineering Advising Password';
	$mail->Body    = 'Hello, you requested to reset your engineering advising appointment scheduler password.';
	$mail->Body .= '<br>Your password is: '.$password.'.';
	 
	if(!$mail->send()) {
	   echo 'Message could not be sent.';
	   echo 'Mailer Error: ' . $mail->ErrorInfo;
	   exit;
	}
	 
	echo 'Message has been sent';
	echo '<br><a href="default.php">Click here to return the homepage.</a>';
}
?>