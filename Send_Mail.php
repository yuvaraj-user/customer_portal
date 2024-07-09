<?php 
require_once __DIR__ . "/../vendor/autoload.php";
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;


Class Send_Mail{

    public $conn;
    public $Created_At;
    public $Created_By;
    function __construct() 
    {

    }

    public function Send_Mail_Details($subject,$attachment,$fileName,$message = '',$to = array(),$cc = array(),$bcc=array())
    {


       $to=array('jr_developer4@mazenetsolution.com','softwaredeveloper@mazenetsolution.com');
      ///  $cc=array('sathish.r@rasiseeds.com');
     ///   $bcc=array('sathishkumaritnsit@gmail.com');
       // $message = '<h5>Hello </h5>';
       $mail = new PHPMailer;
        //$mail->SMTPDebug = 2;                           
        $mail->isSMTP();        
        $mail->Host = "rasiseeds-com.mail.protection.outlook.com";
        $mail->SMTPAuth = false;                      
        $mail->Port = 25;                    
        $mail->From = "desk@rasiseeds.com";
        $mail->FromName = "desk@rasiseeds.com";
       foreach($to as $key => $val){   
             $mail->addAddress($val); 
        }
        // foreach($bcc as $key => $val){   // To Mail ids
        //   $mail->addBCC($val); 
        // }
        // foreach($cc as $key => $val){   // To Mail ids
        //   $mail->addCC($val); 
        // }
        $mail->Subject  = $subject;
        $mail->IsHTML(true);
        $mail->Body = $message;
        $mail->addStringAttachment($attachment, $fileName);
        if(!$mail->send())
        {
         echo "Mailer Error: " . $mail->ErrorInfo;
         return false;
        }
        else
        {
         return true;
        }
    }
}