<?php
/* CEN 3073 Project
Author: Reza Ansary, Justin Gosselin
Modified by: Reza Ansary
Last Modified: 4/17/2015
*/

require 'PHPMailerAutoload.php';
$name = $_POST['name'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$school = $_POST['school'];
$msg = $_POST['msg'];

$mail = new PHPMailer;

//$mail->SMTPDebug = 3;                               // Enable verbose debug output

	$mail->isSMTP();                                    
	$mail->Host = 'smtp.gmail.com'; 
	//$mail->SMTPDebug=1;
	$mail->SMTPAuth = true;                               
	$mail->Username = 'sweagle2015@gmail.com';  // for testing purposes only!                          
	$mail->Password = 'sweagle9545';                        
	$mail->SMTPSecure = 'tls'; 
	$mail->Port = 587;                

	$mail->From = 'sweagle2015@gmail.com';
	$mail->FromName = 'Non-FGCU Student'; 
	$mail->addAddress('sweagle2015@gmail.com');
	
	$mail->WordWrap = 50;                                
	$mail->isHTML(true);                                  
	 
	$mail->Subject = 'Non-FGCU student requesting to meet with advisor';
	$mail->Body  = 'Hello, Engineering Advising, ';
	$mail->Body .= '<br> my name is: '.$name.',';
	$mail->Body .= '<br> my email is: '.$email.',';
	$mail->Body .= '<br> my phone number is: '.$phone.',';
	$mail->Body .= '<br> my institution name is: '.$school.',';
	$mail->Body .= '<br> the reason for my appointment is: '.$msg.'.';
	 
	if(!$mail->send()) {
	   echo 'Message could not be sent.';
	   echo 'Mailer Error: ' . $mail->ErrorInfo;
	   exit;
	}else {
    echo 'Message has been sent';
}
?>