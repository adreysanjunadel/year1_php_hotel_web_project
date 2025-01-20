
<?php

require "../../connection.php";

if(isset($_GET["resort_id"])){ 

    $rid = $_GET["resort_id"];

    $wish_rs = Database::search("SELECT * FROM `wishlist` WHERE `resort_id`='".$rid."' ");
    $wish_num = $wish_rs->num_rows;
    $wish_data = $wish_rs->fetch_assoc();


    if($wish_num == 0){ 

        echo ("Something Went Wrong. Please Try Again Later");

    }else{

        Database::iud("INSERT INTO `recent` (`resort_id`,`user_email`) VALUES 
        ('".$rid."', '".$wish_data["user_email"]."')");

        Database::iud("DELETE FROM `wishlist` WHERE `resort_id`='".$rid."'");

        echo ("success");

    }
    

}else{
    echo ("Please Select a Resort");
}

?>