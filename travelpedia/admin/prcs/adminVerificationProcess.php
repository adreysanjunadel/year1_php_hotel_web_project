<?php

require "../../connection.php";

require "../../mail/SMTP.php";
require "../../mail/PHPMailer.php";
require "../../mail/Exception.php";

use PHPMailer\PHPMailer\PHPMailer;

if(isset($_POST["e"])){
    $email = $_POST["e"];

    $admin_rs = Database::search("SELECT * FROM `admin` WHERE `email`='".$email."' ");
    $admin_num = $admin_rs->num_rows;

    if($admin_num == 1){

        $code = uniqid();

        Database::iud("UPDATE `admin` SET `verification_code`='".$code."' WHERE `email`='".$email."' ");

        $mail = new PHPMailer;
         $mail->IsSMTP();
         $mail->Host = 'smtp.gmail.com';
         $mail->SMTPAuth = true;
         $mail->Username = 'xlr8adrsd@gmail.com';
         $mail->Password = 'gber gdxs kbra epgz';
         $mail->SMTPSecure = 'ssl';
         $mail->Port = 465;
         $mail->setFrom('xlr8adrsd@gmail.com', 'Admin Verification');
         $mail->addReplyTo('xlr8adrsd@gmail.com', 'Admin Verification');
         $mail->addAddress($email);
         $mail->isHTML(true);
         $mail->Subject = 'Travelpedia Admin Login Verification Code';
         $bodyContent = '<h1 style="color:green">Your Verification code is '.$code.'</h1>';
         $mail->Body    = $bodyContent;

         if (!$mail->send()){
            echo 'Verification Code Sending Failed';
         } else {
            echo 'Success';
         }

    }else{
        echo ("You are not a valid user");
    }

}else{
    echo ("Email field should not be empty");
}

?>