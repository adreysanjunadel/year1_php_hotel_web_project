<?php

session_start();

if(isset($_SESSION["ru"])){

    $_SESSION["ru"] = null;

    echo ("success");
}

?>