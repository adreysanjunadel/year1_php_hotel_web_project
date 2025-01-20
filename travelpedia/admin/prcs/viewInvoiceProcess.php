<?php
require "../../connection.php";

if (isset($_POST["bid"])) {
    $bid = $_POST["bid"];
    
    $existing_invoice_rs = Database::search("SELECT * FROM `invoice` WHERE `booking_id` = '$bid'");
    if ($existing_invoice_rs->num_rows > 0) {
        echo ("1"); // Booking already has an invoice, so return 1 to indicate success
    } else {
        echo ("0"); // Booking doesn't have an invoice
    }
}
?>