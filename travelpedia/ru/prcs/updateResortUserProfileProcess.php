<?php

session_start();

require "../../connection.php";

if (isset($_SESSION["ru"])) {

    $fname = $_POST["fn"];
    $lname = $_POST["ln"];
    $mobile = $_POST["m"];
    $email = $_SESSION["ru"]["email"];

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

            $file_name = "../../resources/profile_img/".$fname."_".uniqid().$new_file_extention;

            move_uploaded_file($image["tmp_name"], $file_name);

            $image_rs = Database::search("SELECT * FROM `ru_profile_images` WHERE 
            `resort_user_email` ='".$email."'");
            $image_num = $image_rs->num_rows;

            if ($image_num == 1) {

                Database::iud("UPDATE `ru_profile_images` SET `path`='" . $file_name . "' WHERE 
                `resort_user_email`='".$email."'");
                
            } else {

                Database::iud("INSERT INTO `ru_profile_images` (`path`,`resort_user_email`) VALUES 
                ('" . $file_name . "','" . $email . "')");
            }
        }
    }

    Database::iud("UPDATE `resort_user` SET `fname`='" . $fname . "',`lname`='" . $lname . "',`mobile_number`='" . $mobile . "' 
            WHERE `email`='" .$email. "'");

    echo ("success");
    
} else {
    echo ("Please login first");
}
