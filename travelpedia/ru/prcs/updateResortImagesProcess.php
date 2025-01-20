<?php

error_reporting(E_ALL);

session_start();
require "../../connection.php";

if(isset($_SESSION["r"])){

    $rid = $_SESSION["r"]["resort_id"];

$length = sizeof($_FILES);

Database::iud("DELETE FROM `resort_images` WHERE `resort_id` = '".$rid."' ");

if ($length <= 4 && $length > 0) {

  $allowed_img_extensions = array("image/jpg", "image/jpeg", "image/png", "image/svg+xml");;

  for ($x = 0; $x < count($_FILES); $x++){
    if (isset($_FILES["img" . $x])) {

      $img_file = $_FILES["img" . $x];
      $file_extension = $img_file["type"];

      if (in_array($file_extension, $allowed_img_extensions)) {
        $new_img_extension;
        if ($file_extension == "image/jpeg") {
          $new_img_extension = ".jpg";
        } else if ($file_extension == "image/jpg") {
          $new_img_extension = ".jpeg";
        } else if ($file_extension == "image/png") {
          $new_img_extension = ".png";
        } else if ($file_extension == "image/svg+xml") {
          $new_img_extension = ".svg";
        }

        $file_name = "../../resources//resort-images//" . $rid . "_" . $x . "_" . uniqid() . $new_img_extension;
        move_uploaded_file($img_file["tmp_name"], $file_name);

        Database::iud("INSERT INTO `resort_images`(`resort_id`,`image`) VALUES ('" . $rid . "','" . $file_name . "') ");
      } else {
        echo ("Invalid Image type");
      }
    }
  }

  echo ("Resort Image(s) Updated Successfully");
} else {
  echo ("Invalid Image Count");
}

}