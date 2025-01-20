<?php

use Random\BrokenRandomEngineError;

error_reporting(E_ALL);

session_start();

$email = $_SESSION["ru"]["email"];

require "../../connection.php";

$rname = $_POST["rname"];
$rmo = $_POST["rmo"];

if (empty($rname)) {
    echo ("Please enter a name for your resort");
} else if (empty($rmo)) {
    echo ("Please enter a contact number for your resort");
} else if (strlen($rmo) != 10) {
    echo ("Mobile Number must have 10 characters");
} else if (!preg_match("/07[0,1,2,4,5,6,7,8][0-9]/", $rmo)) { //checks if our value matches the regular expression
    echo ("Your Mobile Number is Invalid!!");
} else {

    $d = new DateTime();
    $tz = new DateTimeZone("Asia/Colombo");
    $d->setTimezone($tz);
    $datetime = $d->format("Y-m-d H:i:s");

    $status = 1;

    $resort_entry = Database::iud("INSERT INTO `resort` 
    (`resort_name`,`resort_user_email`,`resort_mobile`,`datetime_added`,`status`) VALUES 
    ('" . $rname . "','".$email."','" . $rmo . "','" . $datetime . "', '".$status."')");

    $resort_id = mysqli_insert_id(Database::$connection);
    echo "<script>alert('Resort saved successfully. <br/>USE Resort ID: " . $resort_id . "<br />');</script>";

    ?><br/><?php

    $res_rs = Database::search("SELECT * FROM `resort` WHERE `resort_name` = '" . $rname . "' ");
    $res_dt = $res_rs->fetch_assoc();
    json_encode($res_dt["resort_id"]);

    if (isset($_FILES["image"])) {
        $image = $_FILES["image"];

        $allowed_image_extensions = array("image/jpg", "image/jpeg", "image/png", "image/svg+xml");
        $file_ex = $image["type"];

        if (!in_array($file_ex, $allowed_image_extensions)) {
            echo ("Please select a valid image.");
        } else {

            $new_file_extension;

            if ($file_ex == "image/jpg") {
                $new_file_extension = ".jpg";
            } else if ($file_ex == "image/jpeg") {
                $new_file_extension = ".jpeg";
            } else if ($file_ex == "image/png") {
                $new_file_extension = ".png";
            } else if ($file_ex == "image/svg+xml") {
                $new_file_extension = ".svg";
            }

            $file_name = "../../resources//resort-tn-images//" . $res_dt["resort_name"] . "_" . uniqid() . $new_file_extension;

            move_uploaded_file($image["tmp_name"], $file_name);

            $image_rs = Database::search("SELECT * FROM `resort_thumbnail` WHERE 
            `resort_id`='" . $resort_id . "'");
            $image_num = $image_rs->num_rows;

            if ($image_num == 0) {
                Database::iud("INSERT INTO `resort_thumbnail` (`resort_thumbnail`,`resort_id`) VALUES 
            ('" . $file_name . "','" . $resort_id . "') ");
                echo ("Thumbnail Uploaded");
            } else {
                echo ("Failed to Upload Thumbnail Image");
            }
        }
    }
}
