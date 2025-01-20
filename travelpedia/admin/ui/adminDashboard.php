<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Admin Dashboard | Travelpedia</title>

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
                            <a class="nav-link active" aria-current="page" href="#">Dashboard</a>
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
                            <a class="nav-link" href="searchInvoices.php">Search Invoices</a>
                            <a class="nav-link disabled" href="#">View Invoice</a>
                        </nav>
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-10">
                    <div class="row">

                        <div class="text-white fw-bold mb-1 mt-3">
                            <h2 class="fw-bold text-dark m-4">Dashboard</h2>
                        </div>
                        <div class="col-12">
                            <hr />
                        </div>
                        <div class="col-12">
                            <div class="row g-1">

                                <div class="col-6 col-lg-4 px-1 shadow">
                                    <div class="row g-1">
                                        <div class="col-12 bg-white text-dark text-center rounded" style="height: 100px;">
                                            <br />
                                            <span class="fs-4 fw-bold">Today's Income</span>
                                            <br />
                                            <?php

                                            $today = date("Y-m-d");
                                            $thismonth = date("m");
                                            $thisyear = date("Y");

                                            $a = "0";
                                            $b = "0";
                                            $c = "0";
                                            $e = "0";
                                            $f = "0";

                                            $invoice_rs = Database::search("SELECT * FROM `invoice`");
                                            $invoice_num = $invoice_rs->num_rows;

                                            for ($x = 0; $x < $invoice_num; $x++) {
                                                $invoice_data = $invoice_rs->fetch_assoc();

                                                $f = $f + $invoice_num; //total qty

                                                $d = $invoice_data["date_time"];
                                                $splitDate = explode(" ", $d); //separate date from time
                                                $pdate = $splitDate[0]; //sold date

                                                if ($pdate == $today) {
                                                    $a = $a + $invoice_data["total"];
                                                    $c = $c + $invoice_num;
                                                }

                                                $splitMonth = explode("-", $pdate); //separate date as year,month & date
                                                $pyear = $splitMonth[0]; //year
                                                $pmonth = $splitMonth[1]; //month

                                                if ($pyear == $thisyear) {
                                                    if ($pmonth == $thismonth) {
                                                        $b = $b + $invoice_data["total"];
                                                        $e = $e + $invoice_num;
                                                    }
                                                }
                                            }

                                            ?>
                                            <span class="fs-5">$ <?php echo $a; ?> .00</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-6 col-lg-4 px-1">
                                    <div class="row g-1">
                                        <div class="col-12 bg-success text-white text-center rounded" style="height: 100px;">
                                            <br />
                                            <span class="fs-4 fw-bold">Monthly Income</span>
                                            <br />

                                            <span class="fs-5">$ <?php echo $b; ?> .00</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-6 col-lg-4 px-1">
                                    <div class="row g-1">
                                        <div class="col-12 bg-danger text-white text-center rounded" style="height: 100px;">
                                            <br />
                                            <span class="fs-4 fw-bold">Today's Bookings</span>
                                            <br />
                                            <span class="fs-5"><?php echo $c; ?> Bookings</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-6 col-lg-4 px-1">
                                    <div class="row g-1">
                                        <div class="col-12 bg-primary text-white text-center rounded" style="height: 100px;">
                                            <br />
                                            <span class="fs-4 fw-bold">Monthly Bookings</span>
                                            <br />
                                            <span class="fs-5"><?php echo $e; ?> Bookings</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-6 col-lg-4 px-1">
                                    <div class="row g-1">
                                        <div class="col-12 bg-secondary text-white text-center rounded" style="height: 100px;">
                                            <br />
                                            <span class="fs-4 fw-bold">Total Bookings</span>
                                            <br />
                                            <span class="fs-5"><?php echo $f; ?> Bookings</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-6 col-lg-4 px-1 shadow">
                                    <div class="row g-1">
                                        <div class="col-12 bg-dark text-white text-center rounded" style="height: 100px;">
                                            <br />
                                            <span class="fs-4 fw-bold">Users Engaged</span>
                                            <br />
                                            <?php
                                            $user_rs = Database::search("SELECT * FROM `user`");
                                            $user_num = $user_rs->num_rows;
                                            ?>
                                            <span class="fs-5"><?php echo $user_num; ?> Members</span>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="col-12">
                            <hr />
                        </div>

                        <div class="col-12 bg-dark">
                            <div class="row">
                                <div class="col-12 col-lg-2 text-center my-3">
                                    <label class="form-label fs-4 fw-bold text-white">Total Active Time</label>
                                </div>
                                <div class="col-12 col-lg-10 text-center my-3">
                                    <?php

                                    $start_date = new DateTime("2023-03-01 00:00:00");

                                    $tdate = new DateTime();
                                    $tz = new DateTimeZone("Asia/Colombo");
                                    $tdate->setTimezone($tz);

                                    $end_date = new DateTime($tdate->format("Y-m-d H:i:s"));

                                    $difference = $end_date->diff($start_date);

                                    ?>
                                    <label class="form-label fs-4 fw-bold text-warning">
                                        <?php

                                        echo $difference->format('%Y') . " Years " . $difference->format('%m') . " Months " .
                                            $difference->format('%d') . " Days " . $difference->format('%H') . " Hours " .
                                            $difference->format('%i') . " Minutes " . $difference->format('%s') . " Seconds ";
                                        ?>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="offset-1 col-10 col-lg-4 my-3 rounded bg-body">
                            <div class="row g-1">
                                <div class="col-12 text-center">
                                    <label class="form-label fs-4 fw-bold text-decoration-underline">Top Grossing Resort</label>
                                </div>
                                <?php

                                $freq_rs = Database::search("SELECT `resort_id`,COUNT(`resort_id`) AS `value_occurence` 
                                FROM `invoice` WHERE `date_time` LIKE '%" . $thisyear . "%' GROUP BY `resort_id` ORDER BY 
                                `value_occurence` DESC LIMIT 1");

                                $freq_num = $freq_rs->num_rows;
                                if ($freq_num > 0) {
                                    $freq_data = $freq_rs->fetch_assoc();

                                    $resort_rs = Database::search("SELECT * FROM `resort` WHERE `resort_id`='" . $freq_data["resort_id"] . "'");
                                    $resort_data = $resort_rs->fetch_assoc();

                                    $image_rs = Database::search("SELECT * FROM `resort_images` WHERE `resort_id`='" . $freq_data["resort_id"] . "'");
                                    $image_data = $image_rs->fetch_assoc();

                                    $invoice_rs = Database::search("SELECT SUM(`invoice_id`) AS `sum` FROM `invoice` WHERE 
                                    `resort_id`='" . $freq_data["resort_id"] . "' AND `date_time` LIKE '%" . $thisyear . "%'");
                                    $invoice_data = $invoice_rs->fetch_assoc();

                                ?>

                                    <div class="col-12 text-center shadow">
                                        <img src="<?php echo $image_data["image"]; ?>" class="img-fluid rounded-top" style="height: 250px;" />
                                    </div>
                                    <div class="col-12 text-center my-3">
                                        <span class="fs-5 fw-bold"><?php echo $resort_data["resort_name"]; ?></span><br />
                                        <span class="fs-6"><?php echo $invoice_data["sum"]; ?> bookings</span><br />
                                    </div>
                                <?php

                                } else {
                                ?>
                                    <div class="col-12 text-center shadow">
                                        <img src="../../resources/empty.svg" class="img-fluid rounded-top" style="height: 250px;" />
                                    </div>
                                    <div class="col-12 text-center my-3">
                                        <span class="fs-5 fw-bold">-----</span><br />
                                        <span class="fs-6">--- bookings</span><br />
                                        <span class="fs-6">$ ----- .00</span>
                                    </div>
                                <?php
                                }

                                ?>

                                <div class="col-12">
                                    <div class="first-place"></div>
                                </div>
                            </div>
                        </div>

                        <div class="offset-1 col-10 col-lg-4 my-3 rounded bg-body">
                            <div class="row g-1">
                                <?php
                                if ($freq_num > 0) {

                                    $profile_rs = Database::search("SELECT * FROM `ru_profile_images` WHERE 
                                `resort_user_email`='" . $resort_data["resort_user_email"] . "'");
                                    $profile_data = $profile_rs->fetch_assoc();

                                    $user_rs1 = Database::search("SELECT * FROM `resort_user` WHERE `email`='" . $resort_data["resort_user_email"] . "'");
                                    $user_data1 = $user_rs1->fetch_assoc();

                                ?>
                                    <div class="col-12 text-center">
                                        <label class="form-label fs-4 fw-bold text-decoration-underline">Top Grossing Resort User</label>
                                    </div>
                                    <div class="col-12 text-center shadow">
                                        <img src="<?php echo $profile_data["path"]; ?>" class="img-fluid rounded-top" style="height: 250px;" />
                                    </div>
                                    <div class="col-12 text-center my-3">
                                        <span class="fs-5 fw-bold"><?php echo $user_data1["fname"]." ".$user_data1["lname"]; ?></span><br />
                                        <span class="fs-6"><?php echo $user_data1["email"]; ?></span><br />
                                        <span class="fs-6"><?php echo $user_data1["mobile_number"]; ?></span>
                                    </div>
                                <?php
                                } else {
                                ?>
                                    <div class="col-12 text-center">
                                        <label class="form-label fs-4 fw-bold text-decoration-underline">Most Famous Booker</label>
                                    </div>
                                    <div class="col-12 text-center shadow">
                                        <img src="../../resources/new_user.svg" class="img-fluid rounded-top" style="height: 250px;" />
                                    </div>
                                    <div class="col-12 text-center my-3">
                                        <span class="fs-5 fw-bold">----- -----</span><br />
                                        <span class="fs-6">-----</span><br />
                                        <span class="fs-6">----------</span>
                                    </div>
                                <?php
                                }


                                ?>

                                <div class="col-12">
                                    <div class="first-place"></div>
                                </div>
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