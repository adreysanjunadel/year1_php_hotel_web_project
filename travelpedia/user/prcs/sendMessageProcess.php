<?php

session_start();
require "../../connection.php";

$sender = $_SESSION["u"]["email"];
$receiver = $_POST["e"];
$msg = $_POST["t"];

$d = new DateTime();
$tz = new DateTimeZone("Asia/Colombo");
$d->setTimezone($tz);
$date = $d -> format("Y-m-d H:i:s");

$admin_rs = Database::search("SELECT *  FROM `admin` WHERE `email` = '" . $receiver. "' ");
$admin_num = $admin_rs-> num_rows;

$user_rs = Database::search("SELECT *  FROM `user` WHERE `email` = '" . $receiver. "' ");
$user_num = $user_rs-> num_rows;

if($admin_num == 1 || $user_num == 1){
    Database::iud("INSERT INTO `chat` (`content`,`date_time`,`status`,`from`,`to`) VALUES ('".$msg."','".$date."','0','".$sender."','".$receiver."') ");

    echo ("Success");
}

?>