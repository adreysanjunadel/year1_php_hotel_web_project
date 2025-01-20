<?php

session_start();

require "../../connection.php";

if (isset($_SESSION["u"])) {

    $fname = $_POST["fn"];
    $lname = $_POST["ln"];
    $mobile = $_POST["m"];
    $no = $_POST["no"];
    $street1 = $_POST["s1"];
    $street2 = $_POST["s2"];
    $province = $_POST["p"];
    $district = $_POST["d"];
    $city = $_POST["c"];

    if (isset($_FILES["image"])) {
        $image = $_FILES["image"];

        $allowed_image_extentions = array("image/jpg", "image/jpeg", "image/png", "image/svg+xml");
        $file_ex = $image["type"];

        if (!in_array($file_ex, $allowed_image_extentions)) {
            echo ("Please select a valid image.");
        } else {

            $new_file_extention;

            if ($file_ex == "image/jpg") {
                $new_file_extention = ".jpg";
            } else if ($file_ex == "image/jpeg") {
                $new_file_extention = ".jpeg";
            } else if ($file_ex == "image/png") {
                $new_file_extention = ".png";
            } else if ($file_ex == "image/svg+xml") {
                $new_file_extention = ".svg";
            }

            $file_name = "../../resources/profile_img/".$_SESSION["u"]["fname"]."_".uniqid().$new_file_extention;

            move_uploaded_file($image["tmp_name"], $file_name);

            $image_rs = Database::search("SELECT * FROM `profile_images` WHERE 
            `user_email`='" . $_SESSION["u"]["email"] . "'");
            $image_num = $image_rs->num_rows;

            if ($image_num == 1) {

                Database::iud("UPDATE `profile_images` SET `path`='" . $file_name . "' WHERE 
                `user_email`='".$_SESSION["u"]["email"]."'");
            } else {

                Database::iud("INSERT INTO `profile_images` (`path`,`user_email`) VALUES 
                ('" . $file_name . "','" . $_SESSION["u"]["email"] . "')");
            }
        }
    }

    Database::iud("UPDATE `user` SET `fname`='" . $fname . "',`lname`='" . $lname . "',`mobile_number`='" . $mobile . "' 
            WHERE `email`='" . $_SESSION["u"]["email"] . "'");

    $address_rs = Database::search("SELECT * FROM `user_address` WHERE 
            `user_email`='" . $_SESSION["u"]["email"] . "'");
    $address_num = $address_rs->num_rows;

    if ($address_num == 1) {

        Database::iud("UPDATE `user_address` SET `no`= '" .$no. "', `street1`='" . $street1 . "',
                `street2`='" . $street2 . "',
                `city_id`='" . $city . "' WHERE `user_email`='" . $_SESSION["u"]["email"] . "'");
    } else {

        Database::iud("INSERT INTO `user_address` 
                (`no`,`street1`,`street2`,`user_email`,`city_id`) VALUES 
                ('".$no."', '" . $street1 . "','" . $street2 . "','" . $_SESSION["u"]["email"] . "','" . $city . "')");
    }

    echo ("success <br/> image data will load upon next sign in");
    
} else {
    echo ("Please login first");
}
