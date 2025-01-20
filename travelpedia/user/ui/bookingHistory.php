<!DOCTYPE html>

<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Booking History | Travelpedia</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../../style.css" />

    <link rel="icon" href="../../resources/travelpedia.jpg" />
</head>

<body class="bg vw-100 scrollbar" style="background-image: linear-gradient(#814A3E, #1F4A5E); overflow-x:hidden;">

    <div class="container-fluid">
        <div class="row">

            <?php include "header.php";

            if (isset($_SESSION["u"])) {
                $umail = $_SESSION["u"]["email"];
            ?>

                <h1 class="text-align-start mt-5 mb-5 text-light" style="margin-left: 5%;">Your Booking History</h1>
                +
                <div class="col-12 mb-4">
                    <div class="row">

                        <?php

                        $book_rs = Database::search("SELECT * FROM `booking`
                        INNER JOIN `resort` ON `booking`.`resort_id` = `resort`.`resort_id`
                        INNER JOIN `resort_thumbnail` ON `resort`.`resort_id` = `resort_thumbnail`.`resort_id`
                        INNER JOIN `room_rates` ON `resort`.`resort_id` = `room_rates`.`resort_id`
                        INNER JOIN `resort_address` ON `resort`.`resort_id` = `resort_address`.`resort_id`
                        INNER JOIN `city` ON `resort_address`.`city_id` = `city`.`city_id`
                        INNER JOIN `district` ON `city`.`district_id` = `district`.`id`
                        INNER JOIN `province` ON `district`.`province_id` = `province`.`id` WHERE `resort`.`status`='1' AND `booking`.`user_email` = '" . $umail . "'");
                        $book_num = $book_rs->num_rows;

                        if ($book_num == 0) {

                        ?>
                            <!-- empty list -->
                            <div class="col-12">
                                <div class="row">

                                    <div class="col-12 text-center">
                                        <label class="form-label fs-1 fw-bold text-center">You have no travel resorts in your booking yet.</label>
                                    </div>
                                    <div class="col-12 empty mb-5"></div>
                                    <div class="offset-lg-4 col-12 col-lg-4 d-grid mb-3">
                                        <a href="home.php" class="btn btn-outline-info fs-3 fw-bold">Start Booking</a>
                                    </div>
                                </div>
                            </div>
                            <!-- empty list -->

                            <?php

                        } else {

                            for ($b = 0; $b < $book_num; $b++) {
                                $book_data = $book_rs->fetch_assoc();

                                $room_rs = Database::search("SELECT * FROM `room_rates`
                                INNER JOIN `resort` ON `room_rates`.`resort_id` = `resort`.`resort_id`
                                WHERE `resort`.`resort_id` = '" . $book_data["resort_id"] . "' ");
                                $room_data = $room_rs->fetch_assoc();
                            ?>

                                <!-- not empty bh -->

                                <div class="offset-1 offset-md-2 col-10 col-md-8 mb-3">
                                    <div class="card flex-row" style="width: 98%; height: 100%;">
                                        <!-- Make card slightly smaller -->
                                        <div class="col-5" style="background: url('<?php echo $book_data["resort_thumbnail"]; ?>'); background-repeat: no-repeat; background-size: cover;"></div>
                                        <div class="col-7 d-flex flex-column" style="background-image: linear-gradient(#777777, #F9ECD8);">
                                            <div class="card-body text-center d-flex flex-column justify-content-between">
                                                <h5 class="text-center text-light"><?php echo $book_data['resort_name'] . ", " . $book_data['city_name'] ?></h5>
                                                <h4>Details: &nbsp;<?php echo $book_data["description"]; ?> </h4>
                                                <br />
                                                <h6 class="fw-bold">Resort Address: &nbsp;&nbsp;<?php echo $book_data["no"]  . " ,&nbsp; " . $book_data["street1"] . " ,&nbsp; " . $book_data["street2"] . " ,&nbsp " . $book_data["city_name"] . " ,&nbsp; " . $book_data["district_name"] . " ,&nbsp; " . $book_data["province_name"]; ?> Province</h6><br />
                                                <h6 class="fw-bold">Contact No. : <?php echo $book_data["resort_mobile"]; ?> (Contact For Further Queries / Booking Cancellation Inquiries) </h6> <br />
                                                <h5 class="fw-bold mb-4">Dates Booked : <?php echo $book_data["check_in"]; ?> &nbsp; &nbsp; - &nbsp; &nbsp; <?php echo $book_data["check_out"]; ?></h5>
                                                <?php
                                                $savedinv_rs = Database::search("SELECT * FROM `invoice`
                    INNER JOIN `booking` ON `invoice`.`booking_id` = `booking`.`booking_id` WHERE `invoice`.`booking_id`='" . $book_data['booking_id'] . "' ");
                                                $savedinv_num = $savedinv_rs->num_rows;

                                                for ($sv = 0; $sv < $savedinv_num; $sv++) {
                                                    $savedinv_data = $savedinv_rs->fetch_assoc();
                                                ?>
                                                    <div class="col-12 btn btn-outline-primary fw-bold fs-5 rounded mb-2" onclick="customerViewInvoice('<?php echo $savedinv_data['booking_id']; ?>');">View Invoice</div>
                                                <?php
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <!-- not empty bh -->

                            <?php
                            }
                            ?>

                    </div>
                </div>
        <?php
                        }
                    } else {
                        echo '<div class="col-12 vh-100">
                                    <div class="row">

                                        <div class="col-12 text-center p-4">
                                            <h1 class="form-label fw-bold text-center" style="margin-bottom: 5%;">Please Log In! 🙏🏼</h1>
                                        </div>
                                        <div class="col-12 adminEmpty"></div>
                                    </div>
                                </div>';
                    }
        ?>

        <?php include "../../footer.php"; ?>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
    <script src="../../js/script.js"></script>
</body>

</html>