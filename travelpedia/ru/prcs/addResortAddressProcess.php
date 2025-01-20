<?php

error_reporting(E_ALL);

session_start();

require "../../connection.php";

if (isset($_SESSION["ru"])) {

    $ra_id = $_POST["ra-id"];
    $rno = $_POST["rno"];
    $rst1 = $_POST["rst1"];
    $rst2 = $_POST["rst2"];
    $rc = $_POST["rc"];

    $res_rs = Database::search("SELECT * FROM `resort_address` WHERE `resort_id` = '" . $ra_id . "' ");
    $res_no = $res_rs->num_rows;

    if ($res_no == 0) {
        $res_dt = $res_rs->fetch_assoc();

        if (empty($rno)) {
            echo ("Please enter an address number for your resort");
        } else if (empty($rst1)) {
            echo ("Please enter an address street name for your resort");
        } else if (empty($rc)) {
            echo ("Please select the city your resort is located at");
        } else {
            Database::iud("INSERT INTO `resort_address` (`no`, `street1`,
`street2`, `city_id`, `resort_id`) VALUES ('" . $rno . "','" . $rst1 . "',
'" . $rst2 . "','" . $rc . "', '" . $ra_id . "') ");

            echo ("Resort address saved successfully");
        }
    } else {
        echo ("Resort Address Exists");
    }
    
} else {
    echo ("Please sign in");
}
