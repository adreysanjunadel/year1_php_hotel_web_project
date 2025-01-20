<?php

session_start();
require "connection.php";

$msg_txt = $_POST["t"];
$receiver = $_POST["e"];

$d = new DateTime();
$tz = new DateTimeZone("Asia/Colombo");
$d->setTimezone($tz);
$date_time = $d->format("Y-m-d H:i:s");

if (isset($_SESSION["au"])) {
    //admin exists, msg sent

    $sender = $_SESSION["au"]["email"];

    $admin_rs = Database::search("SELECT * FROM `admin` WHERE `email` = 'sanjunadelpitiya@gmail.com' ");
    $admin_data = $admin_rs->fetch_assoc();

    Database::iud("INSERT INTO `chat` (`content`,`date_time`,`status`,`from`,`to`)
        VALUES ('" . $msg_txt . "','" . $date_time . "','0','" . $sender . "','" . $receiver . "')");
        echo "success";

} else {
    //admin not in session, msg != sent
    echo ("Error: Message was not sent");
}

?>
