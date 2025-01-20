<?php

require "../../connection.php";

$email = $_POST["e"];
$np = $_POST["n"];
$rnp = $_POST["r"];
$vcode = $_POST["v"];

if(empty($email)){
    echo ("Missing Email Address");
}else if (empty($np)){
    echo ("Please insert a New Password");
}else if(strlen($np)<8 || strlen($np)>24){
    echo ("Invalid Password");
}else if(empty ($rnp)){
    echo ("Please Re-type your New Password");
}else if($np != $rnp){
    echo ("Your Passwords do not match");
}else if(empty ($vcode)){
    echo ("Please enter your Verification Code");
}else{

    $rs = Database::search("SELECT * FROM `user` WHERE `email`='".$email."' AND
    `verification_code`='".$vcode."' ");
    $n = $rs->num_rows;

    if ($n == 1){

        Database::iud("UPDATE `user` SET `password`='".$np."' WHERE `email`='".$email."' ");
        echo ("success");

    }else{
        echo ("Invalid Email or Verification Code");
    }

}

?>