<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Invoice | Travelpedia</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../../style.css" />

    <link rel="icon" href="../../resources/travelpedia.jpg" />
</head>

<body class="bg vw-100 scrollbar" style="overflow-x: hidden;">

    <div class="container-fluid">
        <div class="row" style="background-color: #f5f5dc;">

            <?php include "header.php";

            if (isset($_SESSION["u"])) {
                $umail = $_SESSION["u"]["email"];
                $booking_id = $_GET["booking_id"];
            ?>

                <div class="offset-1 col-10">
                    <hr />
                </div>

                <div class="offset-1 col-10 btn-toolbar justify-content-end">
                    <button class="btn btn-outline-dark btn-rounded fw-bold me-2" onclick="printInvoice();"><i class="bi bi-printer"></i> Print</button>
                    <button class="btn btn-outline-danger btn-rounded fw-bold me-2" onclick="viewAsPDF();"><i class="bi bi-filetype-pdf"></i> Export as PDF</button>
                </div>

                <div class="offset-1 col-10">
                    <hr />
                </div>

                <div class="col-12 invoice" id="page">
                    <div class="row">

                        <div class="offset-1 col-5 p-3">
                            <div class="row">
                                <div class="col-10 offset-1 text-success text-decoration-none text-start">
                                    <h2>Travelpedia</h2>
                                </div>
                                <div class="offset-1 col-10 fw-bold text-start">
                                    <span>1, Street 1, Colombo 2, Sri Lanka</span><br />
                                    <span>+94 112 333 444</span><br />
                                    <span>travelpedia@gmail.com</span>
                                </div>
                            </div>
                        </div>

                        <div class="offset-4 col-2 p-3">
                            <div class="ms-5 headerImage"></div>
                        </div>

                        <div class="offset-1 col-10">
                            <hr class="border border-1 border-primary" />
                        </div>

                        <div class="col-12 p-4">
                            <div class="row">
                                <div class="offset-1 col-5">
                                    <h5 class="fw-500 text-warning">Invoice To :</h5>
                                    <?php
                                    $address_rs = Database::search("SELECT * FROM `user_address`
                                    INNER JOIN `city` ON `user_address`.`city_id` = `city`.`city_id` 
                                    WHERE `user_email`='" . $umail . "'");
                                    $address_data = $address_rs->fetch_assoc();
                                    ?>
                                    <h4 class="text-dark fw-bold"><?php echo strtoupper($_SESSION["u"]["fname"] . " " . $_SESSION["u"]["lname"]); ?></h4>
                                    <br />
                                    <span class="text-secondary fw-bold"><?php echo $_SESSION["u"]["email"]; ?></span>
                                    <br />
                                    <span class="text-secondary fw-bold"><?php echo $address_data["no"] . ", " . $address_data["street1"] . ", " . $address_data["street2"] . ", " . $address_data["city_name"]; ?></span>
                                    <br />
                                </div>

                                <?php
                                $invoice_rs = Database::search("SELECT * FROM `invoice`
                                INNER JOIN `booking` ON `booking`.`booking_id` = `invoice`.`booking_id` 
                                WHERE `invoice`.`booking_id`='" . $booking_id . "'");
                                $invoice_data = $invoice_rs->fetch_assoc();
                                ?>

                                <div class="col-5 text-end p-4">
                                    <h1 class="text-primary">INVOICE 000<?php echo $invoice_data["invoice_id"]; ?></h1>
                                    <span class="fw-bold">Date & Time of Invoice : </span><br />
                                    <span><?php echo $invoice_data["date_time"]; ?></span>
                                </div>
                            </div>
                        </div>

                        <div class="offset-1 col-10">
                            <table class="table">

                                <thead>
                                    <tr class="border border-5 border-secondary">
                                        <th class="border border-dark border-5  border-end">Invoice ID</th>
                                        <th class="border border-dark border-5  border-end">Booking ID & Resort Name</th>
                                        <th class="border border-dark border-5  border-end">Description</th>
                                        <th class="text-end border border-dark border-5 ">Price</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="border-dark" style="height: 72px;">
                                        <td class="bg-info text-white fs-3 border-dark border-start border-end"><?php echo $invoice_data["invoice_id"]; ?></td>
                                        <td class="border-dark border-end">
                                            <span class="fw-bold text-success text-decoration-underline p-2"><?php echo $booking_id; ?></span><br />

                                            <?php
                                            $resort_rs = Database::search("SELECT * FROM `resort` WHERE `resort_id`='" . $invoice_data["resort_id"] . "'");
                                            $resort_data = $resort_rs->fetch_assoc();
                                            ?>

                                            <span class="fw-bold text-success fs-4 p-2"><?php echo $resort_data["resort_name"]; ?></span>
                                        </td>
                                        <td class="fw-bold fs-6 pt-4 border-dark border-end"><?php
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
                                            <?php
                                            echo $invoice_data["checkin"];
                                            ?><br />
                                            <?php
                                            echo $invoice_data["checkout"]
                                            ?></td>
                                        <td class="fw-bold fs-6 text-end pt-4 bg-secondary text-white border-dark border-end">$ <?php echo $invoice_data["total"]; ?> .00</td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <?php
                                    $t = $invoice_data["total"];
                                    ?>
                                    <tr>
                                        <td colspan="2" class="offset-1 border-0"></td>
                                        <td class="fs-5 text-end fw-bold border-primary text-primary">GRAND TOTAL</td>
                                        <td class="text-end border-primary text-primary">$ <?php echo $invoice_data["total"]; ?> .00</td>
                                    </tr>
                                </tfoot>

                            </table>
                        </div>
                        <br />

                        <div class="col-4 text-center">
                            <span class="fs-1 fw-bold text-success">Thank You !</span>
                        </div>

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

                    </div>
                </div>

            <?php
            }
            ?>

            <?php include "../../footer.php"; ?>

        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.2/jspdf.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
    <script src="../../js/script.js"></script>
</body>

</html>