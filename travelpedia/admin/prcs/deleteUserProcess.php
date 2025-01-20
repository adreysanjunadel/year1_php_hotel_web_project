<?php

require "../../connection.php"; //connecting the database

if(isset($_GET["email"])) { //getting the id value attached via javascript 

    $email = $_GET["email"]; //assigning a variable to that

    $user_rs = Database::search("SELECT * FROM `user` WHERE `email`='".$email."'"); //result search for all user related data
    $user_num = $user_rs->num_rows; //number of rows matching above data

    if($user_num == 1){ //if block to delete data

        $user_data = $user_rs->fetch_assoc();
        Database::iud("DELETE FROM `profile_images` WHERE `user_email` = '".$user_data["email"]."' ");
        Database::iud("DELETE FROM `user_address` WHERE `user_email` = '".$user_data["email"]."' ");
        Database::iud("DELETE FROM `user` WHERE `email` = '".$user_data["email"]."' ");

        echo ("success");

    }else{
        echo ("Cannot Find User");
    }

}else{
    echo ("Failed to Delete User");
}

?>