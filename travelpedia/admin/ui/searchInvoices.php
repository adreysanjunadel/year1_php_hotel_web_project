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

<body class="bg vw-100 scrollbar" style="overflow-x: hidden;">

    <div class="container-fluid">
        <div class="row">

            <?php 
            include "adminHeader.php";
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
                            <a class="nav-link" href="checkDailyBookings.php">View Daily Bookings</a>
                        </nav>
                    </div>
                    <div class="col-12">
                        <hr class="border border-1 border-white" />
                        <h4 class="text-white fw-bold">Invoices</h4>
                        <hr class="border border-1 border-white" />
                    </div>
                    <div class="nav flex-column nav-pills p-2" role="tablist" aria-orientation="vertical">
                        <nav class="nav flex-column">
                            <a class="nav-link active" aria-current="page">Search Invoices</a>
                            <a class="nav-link disabled" href="#">View Invoice</a>
                        </nav>
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-10">
                <div class="row">

                    <div class="text-white fw-bold mb-1 mt-3">
                        <h2 class="fw-bold text-dark m-4">Search Invoices</h2>
                    </div>
                    <div class="col-12">
                        <hr />
                    </div>

                    <div class="col-12">
                        <div class="row">
                            <div class="offset-0 offset-lg-3 col-12 col-lg-6 mb-3">
                                <div class="row">
                                    <div class="col-5 d-grid">
                                        <label for="start_date">Start:</label>
                                        <input class="fs-5 fw-bold text-center form-control datepicker" type="date" id="start_date" onchange="searchInvoices(0)">
                                    </div>

                                    <div class="col-5 offset-1 d-grid">
                                        <label for="end_date">End:</label>
                                        <input class="fs-5 fw-bold text-center form-control datepicker" type="date" id="end_date" onchange="searchInvoices(0)">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12" id="invoiceSearchResult">

                            <hr />

                            <?php

                            $query = "SELECT * FROM `booking`
                                INNER JOIN `user` ON `booking`.`user_email` = `user`.`email`
                                INNER JOIN `user_address` ON `user_address`.`user_email` = `user`.`email`
                                INNER JOIN `resort` ON `booking`.`resort_id` = `resort`.`resort_id`
                                INNER JOIN `resort_thumbnail` ON `resort`.`resort_id` = `resort_thumbnail`.`resort_id`
                                INNER JOIN `room_rates` ON `resort`.`resort_id` = `room_rates`.`resort_id`
                                INNER JOIN `resort_address` ON `resort`.`resort_id` = `resort_address`.`resort_id`
                                INNER JOIN `city` ON `resort_address`.`city_id` = `city`.`city_id`
                                INNER JOIN `district` ON `city`.`district_id` = `district`.`id`
                                INNER JOIN `province` ON `district`.`province_id` = `province`.`id`
                                WHERE `resort`.`status`='1' ";

                            $pageno;

                            if (isset($_GET["page"])) {
                                $pageno = $_GET["page"];
                            } else {
                                $pageno = 1;
                            }


                            $invoice_rs = Database::search($query);
                            $invoice_num = $invoice_rs->num_rows;

                            $results_per_page = 6;
                            $number_of_pages = ceil($invoice_num / $results_per_page);

                            $page_results = ($pageno - 1) * $results_per_page;
                            $selected_rs =  Database::search($query . " LIMIT " . $results_per_page . " OFFSET " . $page_results . "");

                            $selected_num = $selected_rs->num_rows;

                            for ($i = 0; $i < $selected_num; $i++) {
                                $selected_data = $selected_rs->fetch_assoc();

                                $room_rs = Database::search("SELECT * FROM `room_rates`
                                INNER JOIN `resort` ON `room_rates`.`resort_id` = `resort`.`resort_id`
                                WHERE `resort`.`resort_id` = '" . $selected_data["resort_id"] . "' ");
                                $room_data = $room_rs->fetch_assoc();
                            ?>


                                <div class="card col-10 offset-1 mt-2 mb-2">
                                    <div class="d-flex">
                                        <div class="card-body col-3 m-4 row">
                                            <img src="<?php echo $selected_data["resort_thumbnail"]; ?>" class="card-img-top img-fluid" placeholder="<?php echo $selected_data["resort_name"]; ?>" style="height: 180px;background-size:contain" />
                                        </div>
                                        <div class="card-body col-lg-6 col-12 row">
                                            <div class="fw-bold d-flex">
                                                <h4 class="offset-1 col-4 row fw-bold p-2">
                                                    <?php echo $selected_data["resort_name"]; ?> &nbsp; &nbsp;&nbsp; &nbsp;
                                                </h4>
                                                <h5 class="col-1 row fw-bold p-2">
                                                    <h4>Details: &nbsp;<?php echo $selected_data["description"]; ?> </h4>
                                                </h5>
                                            </div>
                                            <span class="fw-bold">Resort Address: &nbsp;&nbsp;<?php echo $selected_data["no"]  . " ,&nbsp; " . $selected_data["street1"] . " ,&nbsp; " . $selected_data["street2"] . " ,&nbsp " . $selected_data["city_name"] . " ,&nbsp; " . $selected_data["district_name"] . " ,&nbsp; " . $selected_data["province_name"]; ?> Province</span>
                                            <span class="fw-bold">Contact No. : <?php echo $selected_data["resort_mobile"]; ?> (Contact For Further Queries / Booking Cancellation Inquiries) </span>
                                            <span class="fw-bold">Date of Invoice : <h4><?php echo $selected_data["date_booked"]; ?> &nbsp; &nbsp; &nbsp; <button class="btn btn-outline-success col-6 offset-1 fw-bold" onclick="viewInvoice('<?php echo $selected_data['booking_id']; ?>');">Check Invoice</button></h4></span>
                                        </div>
                                    </div>
                                </div>


                            <?php

                            }
                            ?>

                            <!--  -->
                            <div class="row mt-4">
                                <div class="offset-3 col-6 text-center mb-3">
                                    <nav aria-label="Page navigation example">
                                        <ul class="pagination pagination-lg justify-content-center">
                                            <li class="page-item">
                                                <a class="page-link" href="
                                                <?php if ($pageno <= 1) {
                                                    echo ("#");
                                                } else {
                                                    echo "?page=" . ($pageno - 1);
                                                } ?>
                                                " aria-label="Previous">
                                                    <span aria-hidden="true">&laquo;</span>
                                                </a>
                                            </li>
                                            <?php

                                            for ($x = 1; $x <= $number_of_pages; $x++) {
                                                if ($x == $pageno) {
                                            ?>
                                                    <li class="page-item active">
                                                        <a class="page-link" href="<?php echo "?page=" . ($x); ?>"><?php echo $x; ?></a>
                                                    </li>
                                                <?php
                                                } else {
                                                ?>
                                                    <li class="page-item">
                                                        <a class="page-link" href="<?php echo "?page=" . ($x); ?>"><?php echo $x; ?></a>
                                                    </li>
                                            <?php
                                                }
                                            }

                                            ?>

                                            <li class="page-item">
                                                <a class="page-link" href="
                                                <?php if ($pageno >= $number_of_pages) {
                                                    echo ("#");
                                                } else {
                                                    echo "?page=" . ($pageno + 1);
                                                } ?>
                                                " aria-label="Next">
                                                    <span aria-hidden="true">&raquo;</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </nav>
                                </div>
                            </div>
                            <!--  -->

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