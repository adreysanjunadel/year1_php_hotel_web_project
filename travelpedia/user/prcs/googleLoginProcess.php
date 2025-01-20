<?php
session_start();
require "../../connection.php";

if (isset($_POST['data'])) {
    $data = json_decode($_POST['data'], true);
    $id_token = $data['idtoken'];
    $email = $data['email'];
    $firstName = $data['firstName'];
    $lastName = $data['lastName'];
    $profilePicture = $data['profilePicture'];

    $rs = Database::search("SELECT * FROM `user` WHERE `email` = '" . $email . "'");
    $n = $rs->num_rows;

    if ($n == 1) {
        // User exists
        $d = $rs->fetch_assoc();
        $_SESSION["u"] = $d;
        echo "success";

        setcookie("email", $email, [
            'expires' => time() + (60 * 60 * 24 * 180),
            'path' => '/',                   
            'domain' => 'localhost',
            'secure' => true,
            'httponly' => true,
            'samesite' => 'Lax'
        ]);

    } else {
        // User does not exist, create new user
        $d = new DateTime();
        $tz = new DateTimeZone("Asia/Colombo");
        $d->setTimezone($tz);
        $datetime = $d->format("Y-m-d H:i:s");

        Database::iud("INSERT INTO `user` (`email`, `fname`, `lname`, `joined_datetime`) VALUES ('" . $mail . "', '" . $firstName . "', '" . $lastName . "', '" . $datetime . "')");
        $ins_rs = Database::search("SELECT * FROM `user` WHERE `email` = '" . $email . "'");
        $ins_no = $ins_rs->num_rows;

        if ($ins_no == 1) {
            // User exists
            $ins_d = $ins_rs->fetch_assoc();
            $_SESSION["u"] = $ins_d;
            echo "success";
        }
    }

} else {
    echo "Error: No data received.";
}
