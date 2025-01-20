<?php

require "connection.php";

if(isset($_GET["resort_id"])){

    $rid = $_GET["resort_id"];

    $r_rs = Database::search("SELECT * FROM `resort` WHERE `resort_id`='".$rid."'");
    $r_num = $r_rs->num_rows;

    if($r_num == 1){

        $r_data = $r_rs->fetch_assoc();

        if($r_data["status"] == 1){
            Database::iud("UPDATE `resort` SET `status`= '0' WHERE `resort_id`='".$rid."'");
            echo ("blocked");
        }else if($r_data["status"] == 0){
            Database::iud("UPDATE `resort` SET `status`= '1' WHERE `resort_id`='".$rid."'");
            echo ("unblocked");
        }

    }else{
        echo ("Cannot find the Resort. Please try again later.");
    }

}else{
    echo ("Something went wrong.");
}

?>