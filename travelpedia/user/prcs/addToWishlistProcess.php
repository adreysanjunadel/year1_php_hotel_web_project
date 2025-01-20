<?php

session_start();
require "../../connection.php";

//checks dual criteria
if(isset($_SESSION["u"])){
    if(isset($_GET['resort_id'])){

        $umail = $_SESSION["u"]["email"];
        $rid = $_GET["resort_id"];

        //searching existing wishlist details
        $wishlist_rs = Database::search("SELECT * FROM `wishlist` WHERE `user_email` = '".$umail."' AND `resort_id` = '".$rid."' ");
        $wishlist_num=$wishlist_rs->num_rows;

        //dual function
        if($wishlist_num == 1){
            //if existing remove
            $wishlist_data = $wishlist_rs->fetch_assoc();
            
            Database::iud("DELETE FROM `wishlist` WHERE `resort_id`='".$rid."' ");
            echo ("removed");

        }else{
            //if not existing add
            Database::iud("INSERT INTO `wishlist`(`user_email`,`resort_id`) VALUES ('".$umail."','".$rid."')");
            echo ("added");

        }

    }else{
        //couldn't get resort
        echo ("Something Went Wrong");
    }

}else{
    //no session data
    echo ("Please Login First");
}
