<?php

require "../../connection.php";

$fname = $_POST["f"];
$lname = $_POST["l"];
$email = $_POST["e"];
$password = $_POST["p"];
$mobile = $_POST["m"];
$gender = $_POST["g"];

if(empty($fname)){
    echo ("Please enter your first name");
}else if(strlen($fname) > 50){
    echo ("Your First Name must have less than 50 characters");
}else if(empty($lname)){
    echo ("Please enter your last name");
}else if(strlen($lname) > 50){
    echo ("Your Last Name must have less than 50 characters");
}else if(empty($email)){
    echo ("Please enter your Email");
}else if(strlen($email) >= 100){
    echo ("Your Email must have less than 100 characters");
}else if (!filter_var($email,FILTER_VALIDATE_EMAIL)){
    echo ("Invalid Email");
}else if(empty($password)){
    echo ("Please enter your Password");
}else if
(strlen($password) < 8 ||
 strlen($password) > 24 ||
!preg_match('/[A-Z]/', $password) ||
!preg_match('/[a-z]/', $password) ||
!preg_match('/[0-9]/', $password) ||
!preg_match('/[^A-Za-z0-9]/', $password)){
    echo ("Password must be between 8 - 24 characters and include at least one uppercase letter, one lowercase letter, one number, and one special character.");
}else if(empty($mobile)){
    echo ("Please enter your Mobile Number");
}else if(strlen($mobile) != 10){
    echo ("Mobile Number must have 10 characters");
}else if(!preg_match("/07[0,1,2,4,5,6,7,8][0-9]/",$mobile)){
    echo ("Invalid Mobile");
}else{

$rs = Database::search("SELECT * FROM `resort_user` WHERE `email`='".$email."' OR `mobile_number`='".$mobile."' ");
$n = $rs->num_rows;

if($n > 0){
    echo ("User with the same Email or Mobile already exists !!");
}else{
    $d = new DateTime();
    $tz = new DateTimeZone("Asia/Colombo");
    $d->setTimezone($tz);
    $datetime = $d ->format("Y-m-d H:i:s");

    Database::iud("INSERT INTO `resort_user` (`fname`,`lname`,`email`,`mobile_number`,`password`,`gender_id`,`joined_datetime`,`status`) VALUES
    ('".$fname."','".$lname."','".$email."','".$mobile."','".$password."','".$gender."','".$datetime."','1')");

    echo ("success");
    
}
    
}

?>