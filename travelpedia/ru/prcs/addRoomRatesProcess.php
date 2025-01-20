<?php

error_reporting(E_ALL);

session_start();

require "../../connection.php";

$rrn = $_POST["rrn"];
$drc = $_POST["drc"];
$hdr = $_POST["hdr"];
$fdr = $_POST["fdr"];
$trc = $_POST["trc"];
$htr = $_POST["htr"];
$ftr = $_POST["ftr"];
$src = $_POST["src"];
$hsr = $_POST["hsr"];
$fsr = $_POST["fsr"];

Database::iud("INSERT INTO `resort_roomcount` (`resort_id`,`double`,`triple`,`suite`) VALUES
(' " .$rrn. " ', ' " . $drc . " ', ' " . $trc . " ', ' " . $src . " ') ");

$rc_rs = Database::search("SELECT * FROM `resort_roomcount` WHERE `resort_id` = ' " . $rrn . " ' ");
$rc_n = $rc_rs-> num_rows;

if ($rc_n == 1){
    echo ("Room Count Saved");
} else {
    echo ("Something Went Wrong");
}

?>

<br/>

<?php



Database::iud("INSERT INTO `room_rates` (`resort_id`,`hb_double`,`fb_double`,`hb_triple`,`fb_triple`,`hb_suite`,`fb_suite`)
VALUES (' " .$rrn. " ',  ' " .$hdr. " ',' " .$fdr. " ',' " .$htr. " ',' " .$ftr. " ','".$hsr."', ' " .$fsr. " ') ");

$ro_rs = Database::search("SELECT * FROM `room_rates` WHERE `resort_id` = ' " . $rrn . " ' ");
$ro_n = $ro_rs-> num_rows;

if ($ro_n == 1){
    echo ("Room Rates Saved");
} else {
    echo ("Something Went Wrong");
}

?>
