<?php

session_start();
require "../../connection.php";

if(isset($_SESSION["u"])){

    $rid = $_GET["resort_id"];
    $umail = $_SESSION["u"]["email"];

    $array;
    $order_id = uniqid();

    $resort_rs = Database::search("SELECT * FROM `resort` 
    INNER JOIN `user` ON `resort`.`resort_user_email` = `user`.`email`
    INNER JOIN `resort_thumbnail` ON `resort`.`resort_id` = `resort_thumbnail`.`resort_id`
    INNER JOIN `room_rates` ON `resort`.`resort_id` = `room_rates`.`resort_id`
    INNER JOIN `resort_roomcount` ON `resort`.`resort_id` = `resort_roomcount`.`resort_id`
    INNER JOIN `resort_address` ON `resort`.`resort_id` = `resort_address`.`resort_id`
    INNER JOIN `city` ON `resort_address`.`city_id` = `city`.`city_id`
    INNER JOIN `district` ON `city`.`district_id` = `district`.`id`
    INNER JOIN `province` ON `district`.`province_id` = `province`.`id` 
    WHERE `resort`.`resort_id` = '" . $rid . "' AND `resort`.`status` = '1' ");
    $resort_data = $resort_rs->fetch_assoc();

    $ua_rs = Database::search("SELECT * FROM `user_address` WHERE
    `user_email` = '".$umail."' ");
    $ua_data = $ua_rs->fetch_assoc();

    $city_name_rs = Database::search("SELECT * FROM `city` WHERE `city_id` = '".$ua_data["city_id"]."' ");
    $city_name_data = $city_name_rs->fetch_assoc();

    $fname = $_SESSION["u"]["fname"];
    $lname = $_SESSION["u"]["lname"];
    $mobile = $_SESSION["u"]["mobile_number"];
    $user_address = $ua_data["no"].$ua_data["street1"].$ua_data["street2"];
    $city = $city_name_data["city_name"];
    $resort_address = $resort_data["no"].$resort_data["street1"].$resort_data["street2"];
    $resort_city = $resort_data["city_name"];
    $currency = "LKR";
    $merchant_secret = 'ENTER_YOUR_MERCHANT_SECRET_HERE';

    $array["booking_id"] = $booking_id;
    $array["resort_name"] = $resort_data["resort_name"];
    $array["fname"] = $fname;
    $array["lname"] = $lname;
    $array["mobile"] = $mobile;
    $array["address"] = $user_address;
    $array["city"] = $city;
    $array["resort_address"] = $resort_address;
    $array["resort_city"] = $resort_city;
    $array["mail"] = $email;
    
    // $hash = strtoupper(
    //     md5(
    //         '1221408' . 
    //         $order_id . 
    //         number_format(2000, 2, '.', '') . 
    //         $currency .  
    //         strtoupper(md5($merchant_secret)) 
    //     ) 
    // );

    // $array["hash"] = $hash;

    echo json_encode($array);

} else {
    echo ("1");
}
