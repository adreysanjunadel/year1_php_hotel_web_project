<?php

session_start();

require "connection.php";

$rumail = $_SESSION["ru"]["email"];
$rid = $_GET["id"];

$resort_rs = Database::search("SELECT * FROM `resort` WHERE `resort_id`='".$rid."' ");
$resort_num = $resort_rs->num_rows;

if ($resort_num == 1){

    $resort_data = $resort_rs->fetch_assoc();
    $_SESSION["r"] = $resort_data;
    echo ("success");

} else {
    echo "Something went wrong";
}

?>