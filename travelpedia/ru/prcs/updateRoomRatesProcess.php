<?php

error_reporting(E_ALL);

session_start();
require "../../connection.php";

if (isset($_SESSION["ru"])) {

    if (isset($_SESSION["r"])) {

        $rid = $_SESSION["r"]["resort_id"];

        $drc = $_POST["drc"];
        $hdr = $_POST["hdr"];
        $fdr = $_POST["fdr"];
        $trc = $_POST["trc"];
        $htr = $_POST["htr"];
        $ftr = $_POST["ftr"];
        $src = $_POST["src"];
        $sr = $_POST["hsr"];

        $rc_rs = Database::search("SELECT * FROM `resort_roomcount` WHERE `resort_id` = ' " . $rid . " ' ");
        $rc_n = $rc_rs->num_rows;

        if ($rc_n == 1) {
            Database::iud("UPDATE `resort_roomcount` SET `resort_id` = '" . $rid . "', `double` = '" . $drc . "', `triple` = '" . $trc . "', `suite` = '" . $src . "' WHERE `resort_id`='" . $rid . "'  ");
            echo ("Room Count Updated");
        } else {
            Database::iud("INSERT INTO `resort_roomcount` (`resort_id`,`double`,`triple`,`suite`) VALUES
(' " . $rid . " ', ' " . $drc . " ', ' " . $trc . " ', ' " . $src . " ') ");
            echo ("Room Count Updated");
        }

?>

        <br />

<?php
        $ro_rs = Database::search("SELECT * FROM `room_rates` WHERE `resort_id` = ' " . $rid . " ' ");
        $ro_n = $ro_rs->num_rows;

        if ($ro_n == 1) {
            Database::iud("UPDATE `room_rates` SET `resort_id` = ' " . $rid . " ',  `hb_double` = '" . $hdr . "', `fb_double` = '" . $fdr . "', 
        `hb_triple` = '" . $htr . "', `fb_triple` = '" . $ftr . "', `fb_suite` = '" . $sr . "' WHERE `resort_id` = '" . $rid . "' ");
            echo ("Room Rates UPDATED");
        } else {
            Database::iud("INSERT INTO `room_rates` (`resort_id`,`hb_double`,`fb_double`,`hb_triple`,`fb_triple`,`fb_suite`)
VALUES (' " . $rid . " ',  ' " . $hdr . " ',' " . $fdr . " ',' " . $htr . " ',' " . $ftr . " ',' " . $sr . " ') ");
            echo ("Room Rates UPDATED");
        }
    }
}
?>