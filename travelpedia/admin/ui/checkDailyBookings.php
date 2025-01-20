<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Check Daily Bookings | Travelpedia</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css" />
    <link rel="stylesheet" href="../../style.css" />

    <link rel="icon" href="../../resources/travelpedia.jpg" />
</head>

<body class="bg scrollbar" style="overflow-x: hidden;">

    <div class="container-fluid">
        <div class="row">

            <?php include "adminHeader.php";
            require "../../connection.php";
            $mail = $_SESSION["au"]["email"];
            ?>

            <div class="col-12 col-lg-2 align-items-start bg-info vh-100">
                <div class="row g-1 text-center">

                    <div class="col-12 mt-5">
                        <h4 class="text-white"><?php echo $_SESSION["au"]["fname"] . " " . $_SESSION["au"]["lname"]; ?></h4>
                        <hr class="border border-1 border-white" />
                    </div>
                    <div class="col-12">
                        <hr class="border border-1 border-white" />
                        <h4 class="text-white fw-bold">User Provisioning</h4>
                        <hr class="border border-1 border-white" />
                    </div>
                    <div class="nav flex-column nav-pills p-2" role="tablist" aria-orientation="vertical">
                        <nav class="nav flex-column">
                            <a class="nav-link" href="adminDashboard.php">Dashboard</a>
                            <a class="nav-link" href="manageUsers.php">Manage Users</a>
                            <a class="nav-link" href="manageResortUsers.php">Manage Resort Users</a>
                            <a class="nav-link" href="manageResorts.php">Manage Resorts</a>
                        </nav>
                    </div>
                    <div class="col-12">
                        <hr class="border border-1 border-white" />
                        <h4 class="text-white fw-bold">Daily Bookings</h4>
                        <hr class="border border-1 border-white" />
                    </div>
                    <div class="nav flex-column nav-pills p-2" role="tablist" aria-orientation="vertical">
                        <nav class="nav flex-column">
                            <a class="nav-link active" aria-current="page" href="checkDailyBookings.php">View Daily Bookings</a>
                        </nav>
                    </div>
                    <div class="col-12">
                        <hr class="border border-1 border-white" />
                        <h4 class="text-white fw-bold">Invoices</h4>
                        <hr class="border border-1 border-white" />
                    </div>
                    <div class="nav flex-column nav-pills p-2" role="tablist" aria-orientation="vertical">
                        <nav class="nav flex-column">
                            <a class="nav-link" href="searchInvoices.php">Search Invoices</a>
                            <a class="nav-link disabled" href="#">View Invoice</a>
                        </nav>
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-10">
                <div class="row">

                    <div class="text-white fw-bold mb-1 mt-3">
                        <h2 class="fw-bold text-dark m-4">Daily Bookings</h2>
                    </div>
                    <div class="col-12">
                        <hr />
                    </div>

                    <div class="col-12">
                        <div class="row">

                            <?php

                            $book_rs = Database::search("SELECT * FROM `booking`
                        INNER JOIN `resort` ON `booking`.`resort_id` = `resort`.`resort_id`
                        INNER JOIN `resort_thumbnail` ON `resort`.`resort_id` = `resort_thumbnail`.`resort_id`
                        INNER JOIN `room_rates` ON `resort`.`resort_id` = `room_rates`.`resort_id`
                        INNER JOIN `resort_address` ON `resort`.`resort_id` = `resort_address`.`resort_id`
                        INNER JOIN `city` ON `resort_address`.`city_id` = `city`.`city_id`
                        INNER JOIN `district` ON `city`.`district_id` = `district`.`id`
                        INNER JOIN `province` ON `district`.`province_id` = `province`.`id` 
                        WHERE DATE(`date_booked`) = CURDATE();");
                            $book_num = $book_rs->num_rows;

                            if ($book_num == 0) {

                            ?>
                                <!-- empty list -->
                                <div class="col-12">
                                    <div class="row">

                                        <div class="col-12 text-center p-4">
                                            <h1 class="form-label fw-bold text-center" style="margin-bottom: 5%;">No Bookings today 😢</h1>
                                        </div>
                                        <div class="col-12 adminEmpty"></div>
                                        <!-- Attribution to alert icons -->
                                        <!-- Icons from Flaticon: https://www.flaticon.com/free-icons/alert -->
                                        <!-- Icon author: Pixel Buddha -->
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

                                    <div class="card col-10 offset-1 mt-2 mb-2">
                                        <div class="d-flex">
                                            <div class="card-body col-3 m-4 row">
                                                <img src="<?php echo $book_data["resort_thumbnail"]; ?>" class="card-img-top img-fluid" placeholder="<?php echo $book_data["resort_name"]; ?>" style="height: 180px;background-size:contain" />
                                            </div>
                                            <div class="card-body col-lg-6 col-12 row">
                                                <div class="fw-bold d-flex">
                                                    <h4 class="offset-1 col-4 row fw-bold p-2">
                                                        <?php echo $book_data["resort_name"]; ?> &nbsp; &nbsp;&nbsp; &nbsp;
                                                    </h4>
                                                    <h5 class="col-1 row fw-bold p-2">
                                                        <h4>Details: &nbsp;<?php echo $book_data["description"]; ?> </h4>
                                                    </h5>
                                                </div>
                                                <span class="fw-bold">Resort Address: &nbsp;&nbsp;<?php echo $book_data["no"]  . " ,&nbsp; " . $book_data["street1"] . " ,&nbsp; " . $book_data["street2"] . " ,&nbsp " . $book_data["city_name"] . " ,&nbsp; " . $book_data["district_name"] . " ,&nbsp; " . $book_data["province_name"]; ?> Province</span>
                                                <span class="fw-bold">Contact No. : <?php echo $book_data["resort_mobile"]; ?> (Contact For Further Queries / Booking Cancellation Inquiries) </span>
                                                <span class="fw-bold">Dates Booked : <h4><?php echo $book_data["check_in"]; ?> &nbsp; &nbsp; - &nbsp; &nbsp; <?php echo $book_data["check_out"]; ?></h4></span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- not empty bh -->

                            <?php
                                }
                            }
                            ?>

                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
<script src="../../js/script.js"></script>
</body>