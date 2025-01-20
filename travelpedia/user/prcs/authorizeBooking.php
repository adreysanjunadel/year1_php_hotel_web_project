<?php

session_start();
require "../../connection.php";

if (isset($_SESSION["u"])) {

    $rid = $_GET["resort_id"];
    $umail = $_SESSION["u"]["email"];
    $price = $_GET["price"];

    $array;
    $booking_id = uniqid();

    $resort_rs = Database::search("SELECT * FROM `resort` WHERE `resort_id` = '" . $rid . "' ");
    $resort_data = $resort_rs->fetch_assoc();

    $adrs_rs = Database::search("SELECT * FROM `user_address`
    INNER JOIN `city` ON `city`.`city_id` = `user_address`.`city_id` WHERE `user_email`='" . $umail . "' ");
    $adrs_num = $adrs_rs->num_rows;
    $adrs_data = $adrs_rs->fetch_assoc();

    $array["booking_id"] = $booking_id;
    $array["id"] = $rid;

    $user_address = $adrs_data["no"] . " " . $adrs_data["street1"] . " " . $adrs_data["street2"];

    $resort_name = $resort_data["resort_name"];
    $fname = $_SESSION["u"]["fname"];
    $lname = $_SESSION["u"]["lname"];
    $mobile = $_SESSION["u"]["mobile_number"];
    $mail = $_SESSION["u"]["email"];
    $city = $adrs_data["city_name"];

    $array["id"] = $booking_id;
    $array["resort_name"] = $resort_name;
    $array["amount"] = $price;
    $array["fname"] = $fname;
    $array["lname"] = $lname;
    $array["mobile"] = $mobile;
    $array["address"] = $user_address;
    $array["city"] = $city;
    $array["mail"] = $mail;
    $array["umail"] = $umail;

    $amount = $price;
    $merchant_id = "1221408";
    $order_id = $booking_id;
    $currency = "USD";
    $merchant_secret = "MjI1NTE5MjcxNTcyMDU2MzQyOTM0MDA2MzQ3NDIwNTU0MjU5";

    $hash = strtoupper(
        md5(
            $merchant_id . 
            $order_id . 
            number_format($amount, 2, '.', '') . 
            $currency .  
            strtoupper(md5($merchant_secret)) 
        ) 
    );
    
    $array["hash"] = $hash;

    echo json_encode($array);
} else {
    echo ("1");
}

?>
