<?php

session_start();
require_once "../../connection.php";

if (isset($_SESSION["u"])) {
    $umail = $_SESSION["u"]["email"];

    $bid = $_POST["bid"];
    $rid = $_POST["rid"];
    $cin = $_POST["cin"];
    $cot = $_POST["cot"];
    $dr = $_POST["dr"];
    $tr = $_POST["tr"];
    $sr = $_POST["sr"];
    $dty = $_POST["dty"];
    $tty = $_POST["tty"];
    $sty = $_POST["sty"];
    $t = $_POST["t"];

    $resort_rs = Database::search("SELECT * FROM `resort` 
    INNER JOIN `user` ON `resort`.`resort_user_email` = `user.`email`
    INNER JOIN `resort_thumbnail` ON `resort`.`resort_id` = `resort_thumbnail`.`resort_id`
    INNER JOIN `room_rates` ON `resort`.`resort_id` = `room_rates`.`resort_id`
    INNER JOIN `resort_roomcount` ON `resort`.`resort_id` = `resort_roomcount`.`resort_id`
    INNER JOIN `resort_address` ON `resort`.`resort_id` = `resort_address`.`resort_id`
    INNER JOIN `city` ON `resort_address`.`city_id` = `city`.`city_id`
    INNER JOIN `district` ON `city`.`district_id` = `district`.`id`
    INNER JOIN `province` ON `district`.`province_id` = `province`.`id` 
    WHERE `resort`.`resort_id` = '" . $rid . "' AND `resort`.`status` = '1' ");
    $resort_data = $resort_rs->fetch_assoc();

    # casting values to int type (no database insert conflict)
    $current_doublerooms = $resort_data["double"];
    $new_doublerooms = (int)$current_doublerooms - (int)$dr;

    $current_triplerooms = $resort_data["triple"];
    $new_triplerooms = (int)$current_triplerooms - (int)$tr;

    $current_suiterooms = $resort_data["suite"];
    $new_suiterooms = (int)$current_suiterooms - (int)$sr;

    $a = '';
    $b = '';
    $c = '';

    if ($dr !== '0') {
        $a = "  $dr $dty$ Double Room(s)";
    }

    if ($tr !== '0') {
        $b = "  $tr $tty$ Triple Room(s)";
    }

    if ($sr !== '0') {
        $c = "  $sr $sty$ Suite(s)";
    }

    $description = $a . $b . $c;

    $d = new DateTime();
    $tz = new DateTimeZone("Asia/Colombo");
    $d->setTimezone($tz);
    $datetime = $d->format("Y-m-d H:i:s");

    Database::iud("INSERT INTO `booking`(`booking_id`,`email`,`resort_id`,`description`,`total`,`check_in`,`check_out`,`date_booked`) VALUES
('$bid','$umail', '$rid', '$description' ' booked', '$t', '$cin', '$cot','$datetime') ");

    Database::iud("INSERT INTO `invoice`(`booking_id`,`date_time`,`checkin`,`checkout`,`double`,`triple`,
    `suite`,`double_type`,`triple_type`,`suite_type`,`total`,`status_id`,`resort_id`,`user_email`) VALUES
    ('$bid', '$datetime', '$cin', '$cot', '$dr', '$tr', '$sr', '$dty', '$tty', '$sty', '$t', '0', '$rid', '$umail') ");

    Database::iud("UPDATE `resort_roomcount` SET `double`='" . $new_doublerooms . "', 
`triple`='" . $new_triplerooms . "', `suite`='" . $new_suiterooms . "' WHERE `resort_id` = '" . $rid . "' ");

    echo ("1");
}
