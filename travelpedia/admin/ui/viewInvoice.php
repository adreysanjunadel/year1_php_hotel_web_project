<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>View Invoices | Travelpedia</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../../style.css" />

    <link rel="icon" href="../../resources/travelpedia.jpg" />
</head>

<body class="bg vw-100 scrollbar" style="overflow-x: hidden;">

    <div class="container-fluid">
        <div class="row">

            <?php include "adminHeader.php";

            require "../../connection.php";

            if (isset($_GET["booking_id"])) {
                $booking_id = $_GET["booking_id"];
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
                                <a class="nav-link" href="searchInvoices.php">Search Invoices</a>
                                <a class="nav-link active" href="#" aria-current="page">View Invoice</a>
                            </nav>
                        </div>
                    </div>
                </div>

                <div class="col-10">

                    <div class="offset-1 col-10">
                        <hr />
                    </div>

                    <div class="offset-1 col-10 btn-toolbar justify-content-end">
                        <button class="btn btn-outline-dark btn-rounded fw-bold me-2" onclick="printInvoice();"><i class="bi bi-printer"></i> Print</button>
                        <button class="btn btn-outline-danger btn-rounded fw-bold me-2" onclick="viewAsPDF();"><i class="bi bi-filetype-pdf"></i> Export as PDF</button>
                    </div>

                    <div class="col-12" id="page">
                        <div class="row">

                            <div class="p-2">
                                <hr class="offset-1 col-10" />
                            </div>

                            <div class="offset-1 col-10 rounded invoice-header border border-secondary border-1">
                                <div class="row">
                                    <div class="col-4 p-3">
                                        <div class="ms-5 headerImage"></div>
                                    </div>

                                    <?php
                                    $invoice_rs = Database::search("SELECT * FROM `invoice`
                                INNER JOIN `booking` ON `booking`.`booking_id` = `invoice`.`booking_id` 
                                WHERE `invoice`.`booking_id`='" . $booking_id . "'");
                                    $invoice_data = $invoice_rs->fetch_assoc();
                                    ?>

                                    <div class="offset-4 col-4 p-3 d-flex">
                                        <div class="row">
                                            <div class="offset-3 col-8 text-success text-decoration-none text-end">
                                                <h2 class="fw-bold text-secondary text-start">INVOICE</h2>
                                            </div>
                                            <div class="offset-3 col-8 fw-bold text-start">
                                                <span>Invoice Number &nbsp; 000<?php echo $invoice_data["invoice_id"]; ?></span><br />
                                                <span>Time of Transaction &nbsp; <?php echo $invoice_data["date_time"]; ?> </span><br />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>





                            <div class="col-12 p-4">
                                <div class="row">
                                    <div class="offset-1 col-5">
                                        <h5 class="fw-bold text-warning">Invoice To</h5>
                                        <?php
                                        $booking_rs = Database::search("SELECT * FROM `booking`
                                    INNER JOIN `user` ON `booking`.`user_email` = `user`.`email`
                                    WHERE `booking`.`booking_id` = '" . $booking_id . "' ");
                                        $booking_data = $booking_rs->fetch_assoc();
                                        $address_rs = Database::search("SELECT * FROM `user_address`
                                    INNER JOIN `city` ON `user_address`.`city_id` = `city`.`city_id` 
                                    WHERE `user_email`='" . $booking_data["user_email"] . "'");
                                        $address_data = $address_rs->fetch_assoc();
                                        ?>
                                        <h4 class="text-dark fw-bold"><?php echo strtoupper($booking_data["fname"] . " " . $booking_data["lname"]);  ?></h4>
                                        <br />
                                        <span class="text-secondary fw-bold"><?php echo $booking_data["email"]; ?></span>
                                        <br />
                                        <span class="text-secondary fw-bold"><?php echo $address_data["no"] . ", " . $address_data["street1"] . ", " . $address_data["street2"] . ", " . $address_data["city_name"]; ?></span><br />
                                        <br />
                                    </div>

                                    <div class="col-5 text-end">
                                        <h5 class="fw-bold text-warning">Invoice From</h5>
                                        <h4 class="text-dark fw-bold">WILL SMITH</h4>
                                        <br />
                                        <span class="text-secondary fw-bold">1, Street 1, Colombo 2, Sri Lanka</span><br />
                                        <span class="text-secondary fw-bold">+94 112 333 444</span><br />
                                        <span class="text-secondary fw-bold">travelpedia@gmail.com</span>
                                    </div>
                                </div>
                            </div>

                            <div class="offset-1 col-10">
                                <table class="table">

                                    <thead>
                                        <tr class="border border-1 border-secondary">
                                            <th class="border-dark invoice-header text-secondary">RESORT ID</th>
                                            <th class="border-dark invoice-header text-secondary">BOOKING ID & RESORT NAME</th>
                                            <th class="border-dark invoice-header text-secondary">DESCRIPTION</th>
                                            <th class="text-end border-dark invoice-header text-secondary">PRICE</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="border-dark">
                                            <td class="text-secondary fw-bold fs-5 border-dark border-start p-2 mt-4">00<?php echo $invoice_data["resort_id"]; ?></td>
                                            <td class="border-dark">
                                                <span class="fw-bold fs-5 text-info p-4"><?php echo $booking_id; ?></span>

                                                <?php
                                                $resort_rs = Database::search("SELECT * FROM `resort` WHERE `resort_id`='" . $invoice_data["resort_id"] . "'");
                                                $resort_data = $resort_rs->fetch_assoc();
                                                ?>

                                                <span class="fw-bold text-secondary fs-5 p-2"><?php echo $resort_data["resort_name"]; ?></span>
                                            </td>
                                            <td class="fw-bold fs-5 border-dark"><?php
                                                                                                    $db = $invoice_data["double"];
                                                                                                    $tr = $invoice_data["triple"];
                                                                                                    $su = $invoice_data["suite"];

                                                                                                    $dty = $invoice_data["double_type"];
                                                                                                    $tty = $invoice_data["triple_type"];
                                                                                                    $sty = $invoice_data["suite_type"];

                                                                                                    $a = '';
                                                                                                    $b = '';
                                                                                                    $c = '';

                                                                                                    if ($invoice_data["double"] !== '0') {
                                                                                                        $a = "  $db $dty$ Double Room(s)";
                                                                                                    }

                                                                                                    if ($tr !== '0') {
                                                                                                        $b = "  $tr $tty$ Triple Room(s)";
                                                                                                    }

                                                                                                    if ($su !== '0') {
                                                                                                        $c = "  $su $sty$ Suite(s)";
                                                                                                    }

                                                                                                    $description = $a . $b . $c;
                                                                                                    echo $description;
                                                                                                    echo (" Booked");
                                                                                                    ?><br />

                                                <span class="text-start fs-5"><?php echo $invoice_data["checkin"]; ?> <b>TO</b> </span>
                                                <span class="text-end fs-5"><?php echo $invoice_data["checkout"]; ?> </span>
                                            </td>
                                            <td class="fw-bold fs-5 text-end pt-4 text-dark border-dark border-end">$ <?php echo $invoice_data["total"]; ?> .00</td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr class="border border-dark">
                                            <td colspan="2"></td>
                                            <td class="fs-5 text-center fw-bold border-secondary text-warning">GRAND TOTAL</td>
                                            <td class="fs-5 text-end fw-bold border-secondary text-warning">$ <?php echo $invoice_data["total"]; ?> .00</td>
                                        </tr>
                                    </tfoot>

                                </table>
                            </div>
                            <br />

                            <div class="col-10 offset-1 border-start border-5 border-primary mt-3 mb-3 rounded" style="background-color: #e7f2ff;">
                                <div class="row">
                                    <div class="col-12 mt-3 mb-3">
                                        <label class="form-label fw-bold fs-5">NOTICE : </label><br />
                                        <label class="form-label fs-6">Hotels bookings made can be cancelled for free 5 days within the checkin date</label>
                                        <br />
                                        <label class="form-label fs-6">Kindly retain this invoice for references or any inquiries</label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-10 offset-1">
                                <hr class="border border-1 border-primary" />
                            </div>

                            <div class="col-10 offset-1 text-center mb-3">
                                <label class="form-label fs-5 text-black-50 fw-bold">
                                    Invoice was created on a computer and is valid without the Signature and Seal.
                                </label>
                            </div>

                            <div class="offset-1 col-10 text-center">
                                <span class="fs-1 fw-bold">Thank You !</span>
                            </div>

                        </div>
                    </div>
                </div>

            <?php
            }
            ?>

        </div>
    </div>

    <!-- Load external libraries -->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.5/jspdf.debug.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
    <script src="../../js/script.js"></script>
</body>

</html>