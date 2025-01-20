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
         $mail->Host = 'smtp.gmail.com';
         $mail->SMTPAuth = true;
         $mail->Username = 'xlr8adrsd@gmail.com';
         $mail->Password = 'qrbo dovs uias nrpv';
         $mail->SMTPSecure = 'ssl';
         $mail->Port = 465;
         $mail->setFrom('xlr8adrsd@gmail.com', 'Reset Password');
         $mail->addReplyTo('xlr8adrsd@gmail.com', 'Reset Password');
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