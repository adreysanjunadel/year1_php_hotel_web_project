<?php

session_start();

require "../../connection.php";

// Security Warning: Validate the ID token signature and issuer on the server-side before using the information.
if (isset($_POST['data'])) {
  $data = json_decode($_POST['data'], true);
  $id_token = $data['idtoken'];
  $mail = $data['email'];
  $firstName = $data['firstName'];
  $lastName = $data['lastName'];
  $profilePicture = $data['profilePicture'];

  // Here you can process the user information:
  // - Validate email (optional, might already be validated by Google)
  // - Check if user exists in your database
  // - Create a new user if needed
  // - Start a session or generate a login token

  // Example:
  echo "Welcome, $firstName $lastName! Your email is $mail.";
} else {
  echo "Error: No data received.";
}

$email = $_POST["le"];
$password = $_POST["lp"];
$rememberme = $_POST["r"];

if(empty($email)){
    echo ("Please enter your Email");
}else if(strlen($email) > 100){
    echo ("Your Email must be less than 100 Characters");
}else if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
    echo ("Your Email is Invalid !");
}else if(empty($password)){
    echo ("Please enter your Password");
}else if(strlen($password) < 8 || strlen($password) > 24){
    echo ("Password must be in between 8 - 24 characters");
}else{

    $rs = Database::search("SELECT * FROM `user`
    WHERE `email` ='".$email."' 
    AND `password` ='".$password."' ");
    $n = $rs->num_rows;

    if($n == 1){

        echo ("success");
        $d = $rs->fetch_assoc();
        $_SESSION["u"] = $d;

        if($rememberme == "true"){

            setcookie("email", $email, [
                'expires' => time() + (60 * 60 * 24 * 30),
                'path' => '/',                   
                'domain' => 'localhost',
                'secure' => true,
                'httponly' => true,
                'samesite' => 'Lax'
            ]);
            setcookie("password", $password, [
                'expires' => time() + (60 * 60 * 24 * 30),
                'path' => '/',                   
                'domain' => 'localhost',
                'secure' => true,
                'httponly' => true,
                'samesite' => 'Lax'
            ]);

        } else {

            setcookie("email", "", -1);
            setcookie("password", "", -1);

        }

    }else{
        echo ("Invalid Login Credentials");
    }

}

?>