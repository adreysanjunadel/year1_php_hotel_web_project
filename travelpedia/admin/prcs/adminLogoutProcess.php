<?php

session_start();

if(isset($_SESSION["u"])){

    $_SESSION["au"] = null;
    session_destroy();

    echo ("success");
}

?>