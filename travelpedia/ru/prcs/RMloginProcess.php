<?php

session_start();

require "../../connection.php";

$email = $_POST["e"];
$password = $_POST["p"];
$rememberme = $_POST["r"];

if (empty($email)) {
    echo ("Please enter your Email");
} else if (strlen($email) > 100) {
    echo ("Your Email must be less than 100 Characters");
} else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo ("Your Email is Invalid !");
} else if (empty($password)) {
    echo ("Please enter your Password");
} else if (strlen($password) < 8 || strlen($password) > 24) {
    echo ("Password must be in between 8 - 24 characters");
} else {

    $rs = Database::search("SELECT * FROM `resort_user`
    WHERE `email` ='" . $email . "' AND `password` ='" . $password . "' ");
    $n = $rs->num_rows;

    if ($n == 1) {

        echo ("success");
        $d = $rs->fetch_assoc();
        $_SESSION["ru"] = $d;

        if ($rememberme == "true") {

            setcookie("email", $email, [
                'expires' => time() + (60 * 60 * 24 * 30),
                'path' => '/',                   
                'domain' => 'localhost',
                'secure' => true,
                'httponly' => true,
                'samesite' => 'Strict'
            ]);
            setcookie("password", $password, [
                'expires' => time() + (60 * 60 * 24 * 30),
                'path' => '/',                   
                'domain' => 'localhost',
                'secure' => true,
                'httponly' => true,
                'samesite' => 'Strict'
            ]);

        } else {

            setcookie("email", "", -1);
            setcookie("password", "", -1);
        }
    } else {
        echo ("Invalid Login Credentials");
    }
}
