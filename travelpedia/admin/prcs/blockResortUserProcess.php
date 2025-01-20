<?php

require "../../connection.php";

if(isset($_GET["email"])){

    $email = $_GET["email"];

    $resort_user_rs = Database::search("SELECT * FROM `resort_user` WHERE `email`='".$email."' ");
    $resort_user_num = $resort_user_rs->num_rows;

    if($resort_user_num == 1){

        $resort_user_data = $resort_user_rs->fetch_assoc();

        if($resort_user_data["status"] == 1){
            Database::iud("UPDATE `resort_user` SET `status`= '0' WHERE `email`='".$email."' AND `user_type_id` = '2' ");
            echo ("blocked");
        }else if($resort_user_data["status"] == 0){
            Database::iud("UPDATE `resort_user` SET `status`= '1' WHERE `email`='".$email."' AND `user_type_id` = '2' ");
            echo ("unblocked");
        }

    }else{
        echo ("Cannot find the Resort User. Please try again later.");
    }

}else{
    echo ("Something went wrong.");
}

?>