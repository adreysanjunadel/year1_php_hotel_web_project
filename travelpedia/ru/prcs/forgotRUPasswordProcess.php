<?php

require "../../connection.php";

require "../../mail/SMTP.php";
require "../../mail/PHPMailer.php";
require "../../mail/Exception.php";

use PHPMailer\PHPMailer\PHPMailer;

if(isset($_GET["e"])){

    $email = $_GET["e"];

    $rs = Database::search("SELECT * FROM `resort_user` WHERE `email`='".$email."' ");
    $n = $rs->num_rows;

    if($n == 1){

        $code = uniqid();

        Database::iud("UPDATE `resort_user` SET `verification_code`='".$code."' WHERE
        `email` ='".$email."'");

         $mail = new PHPMailer;
         $mail->IsSMTP();
         $mail->Host = 'ENTER EMAIL PROTOCOL';
         $mail->SMTPAuth = true;
         $mail->Username = 'YOUR_EMAIL_ADDRESS';
         $mail->Password = 'YOUR_3RD_PARTY_ACCESS_TOKEN';
         $mail->SMTPSecure = 'ssl';
         $mail->Port = 'PORT_NUMBER';
         $mail->setFrom('ENTER_YOUR_EMAIL', 'Reset Password');
         $mail->addReplyTo('ENTER_YOUR_EMAIL', 'Reset Password');
         $mail->addAddress($email);
         $mail->isHTML(true);
         $mail->Subject = 'Travelpedia Password Recovery Verification Code';
         $bodyContent = '<h2 style="color:green;">Your Verification code is '.$code.'</h1>';
         $mail->Body    = $bodyContent;

         if (!$mail->send()){
            echo 'Verification Code Sending Failed';
         } else {
            echo 'Success';
         }

    }else{
        echo ("Invalid Email Address");
    }

}else{

    echo ("Please enter your email");

}



?>