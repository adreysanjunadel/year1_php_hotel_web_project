<?php

session_start();

if(isset($_SESSION["u"])){

    $_SESSION["u"] = null;

    echo ("success");
}

?>