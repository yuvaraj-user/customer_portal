<?php
 
  $to = 'winsfolio@gmail.com' . "\r\n";
  $subject = 'Get a Quote Request From Conbiz';
  $name = $_POST['Complete_Name'];
  $email = $_POST['Email_Address']; 
  $phone = $_POST['Phone_No']; 

   $headers .= "Reply-To: $name <$email>\r\n"; 
    $headers .= "Return-Path: The Sender <$email>\r\n"; 
    $headers .= "From: $email" ."\r\n" .
    $headers .= "Conbiz Get A Quote\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-type: text/html; charset=utf-8\r\n";
    $headers .= "X-Priority: 3\r\n";
    $headers .= "X-Mailer: PHP". phpversion() ."\r\n" ;


  $message = "************************************************** \r\n" .
  	         "Request from Conbiz Get a Quote Form!  \r\n" .
             "************************************************** \r\n" .	
    
  	        "Name: " . $name . "\r\n" .
  	        "E-mail: " . $email . "\r\n" .
            "Phone: " . $phone . "\r\n" .


	$mail = mail($to, $subject, $message, $headers); 

 ?>