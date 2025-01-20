<!DOCTYPE html>

<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Wishlist | Travelpedia</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../../style.css" />

    <link rel="icon" href="../../resources/travelpedia.jpg" />
</head>

<body class="bg vw-100 scrollbar" style="overflow-x: hidden;">

    <div class="container-fluid">
        <div class="row">

            <?php include "header.php";

            if (isset($_SESSION["u"])) {
                $umail = $_SESSION["u"]["email"];
            ?>

                <h2 class="text-align-start mt-4 mb-4 fw-bold" style="margin-left: 5%;">Your Wishlist</h2>

                <hr />

                <div class="col-12">
                    <div class="row">

                        <?php
                        
                        $wish_rs = Database::search("SELECT * FROM `wishlist`
                        INNER JOIN `resort` ON `wishlist`.`resort_id` = `resort`.`resort_id`
                        INNER JOIN `resort_thumbnail` ON `resort`.`resort_id` = `resort_thumbnail`.`resort_id`
                        INNER JOIN `room_rates` ON `resort`.`resort_id` = `room_rates`.`resort_id`
                        INNER JOIN `resort_address` ON `resort`.`resort_id` = `resort_address`.`resort_id`
                        INNER JOIN `city` ON `resort_address`.`city_id` = `city`.`city_id`
                        INNER JOIN `district` ON `city`.`district_id` = `district`.`id`
                        INNER JOIN `province` ON `district`.`province_id` = `province`.`id` WHERE `resort`.`status`='1' AND `wishlist`.`user_email` = '" . $umail . "'");
                        $wish_num = $wish_rs->num_rows;

                        if ($wish_num == 0) {

                        ?>
                            <!-- empty list -->
                            <div class="col-12">
                                <div class="row">
                                    
                                    <div class="col-12 text-center">
                                        <label class="form-label fs-1 fw-bold text-center">You have no travel resorts in your wishlist yet.</label>
                                    </div>
                                    <div class="col-12 empty-travel mb-5"></div>
                                    <div class="offset-lg-4 col-12 col-lg-4 d-grid mb-3">
                                        <a href="home.php" class="btn btn-outline-info fs-3 fw-bold">Start Booking</a>
                                    </div>
                                </div>
                            </div>
                            <!-- empty list -->

                        <?php

                        } else {

                            for ($w = 0; $w < $wish_num; $w++) { $wish_data=$wish_rs->fetch_assoc();

                                $room_rs = Database::search("SELECT * FROM `room_rates`
                                INNER JOIN `resort` ON `room_rates`.`resort_id` = `resort`.`resort_id`
                                WHERE `resort`.`resort_id` = '" . $wish_data["resort_id"] . "' ");
                                $room_data = $room_rs->fetch_assoc();
                            ?>

                            <!-- not empty wl -->

                                <div class="card col-12 offset-lg-1 col-lg-10 mt-2 mb-2">
                                    <div class="d-flex">
                                        <div class="card-body col-3 m-4 row">
                                            <img src="<?php echo $wish_data["resort_thumbnail"]; ?>" class="card-img-top img-fluid" placeholder="<?php echo $wish_data["resort_name"]; ?>" style="height: 180px;background-size:contain" />
                                        </div>
                                        <div class="card-body col-lg-6 col-12 row">
                                            <h4 class="fw-bold">
                                                <?php echo $wish_data["resort_name"]; ?> &nbsp; &nbsp; <span class="fs-6">Starting From: $ &nbsp;<?php echo $room_data["hb_double"]; ?> </span>
                                            </h4>
                                            <span class="fw-bold">Resort Address: &nbsp;&nbsp;<?php echo $wish_data["no"]  . " ,&nbsp; " . $wish_data["street1"] . " ,&nbsp; " . $wish_data["street2"] . " ,&nbsp " . $wish_data["city_name"] . " ,&nbsp; " . $wish_data["district_name"] . " ,&nbsp; " . $wish_data["province_name"]; ?> Province</span>
                                            <span class="fw-bold">Contact : <b> <?php echo $wish_data["resort_mobile"]; ?> </b> </span>
                                            <span class="fw-bold">Availability : </span>
                                            <span class="fw-bold">Rating : </span>
                                            <span class="fw-bold">Partner Resort Since : <b> <?php echo $wish_data["datetime_added"]; ?> </b> </span>
                                        </div>
                                        <div class="card-body col-lg-3 col-12 row">
                                            <a class="col-lg-8 offset-lg-2 btn btn-outline-dark p-4 m-3 fw-bold" href='<?php echo "singleResortView.php?resort_id=" . ($wish_data["resort_id"]) ?>'><span class="mt-4 mb-4 fs-5">Make a Booking</span></a>
                                            <a class="col-lg-8 offset-lg-2 btn btn-outline-danger p-4 m-3 fw-bold" onclick="removeFromWishlist(<?php echo $wish_data['resort_id']; ?>);" id="wish">
                                                <span class="fs-5" id='wish<?php echo $wish_data["resort_id"]; ?>'>Remove From Wishlist</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                <!-- not empty wl -->

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
