<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Single Resort View | Travelpedia </title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../../style.css" />

    <link rel="icon" href="../../resources/travelpedia.jpg" />
</head>

<body class="bg vw-100 scrollbar" style="overflow-x: hidden;">

    <div class="container-fluid">
        <div class="row">

            <?php include "header.php";

            ?>

            <div class="col-12">
                <div class="row">
                    <div class="col-12">
                        <div class="row">

                            <div class="col-12 col-lg-2 order-2 order-lg-1">
                                <ul>

                                    <?php

                                    require_once "../../connection.php";

                                    if (isset($_GET["resort_id"])) {

                                        $rid = $_GET["resort_id"];

                                        $resort_rs = Database::search("SELECT * FROM `resort` 
                                        INNER JOIN `resort_user` ON `resort`.`resort_user_email` = `resort_user`.`email`
                                        INNER JOIN `resort_thumbnail` ON `resort`.`resort_id` = `resort_thumbnail`.`resort_id`
                                        INNER JOIN `room_rates` ON `resort`.`resort_id` = `room_rates`.`resort_id`
                                        INNER JOIN `resort_roomcount` ON `resort`.`resort_id` = `resort_roomcount`.`resort_id`
                                        INNER JOIN `resort_address` ON `resort`.`resort_id` = `resort_address`.`resort_id`
                                        INNER JOIN `city` ON `resort_address`.`city_id` = `city`.`city_id`
                                        INNER JOIN `district` ON `city`.`district_id` = `district`.`id`
                                        INNER JOIN `province` ON `district`.`province_id` = `province`.`id` 
                                        WHERE `resort`.`resort_id` = '" . $rid . "' AND `resort`.`status` = '1' ");

                                        $resort_num = $resort_rs->num_rows;

                                        if ($resort_num === 1) {

                                            $resort_data = $resort_rs->fetch_assoc();

                                            $image_rs = Database::search("SELECT * FROM `resort_images` WHERE `resort_id`='" . $rid . "'");
                                            $image_num = $image_rs->num_rows;
                                            $img = array();

                                            if ($image_num != 0) {

                                                for ($x = 0; $x < $image_num; $x++) {
                                                    $image_data = $image_rs->fetch_assoc();
                                                    $img[$x] = $image_data["image"];
                                    ?>

                                                    <li class="d-flex flex-column justify-content-center align-items-center 
                                                border border-1 border-secondary mb-1">
                                                        <img src="<?php echo $img["$x"]; ?>" style="height: 200px;" class="img-thumbnail mt-1 mb-1" id="resortImg<?php echo $x; ?>" onclick="loadMainImg(<?php echo $x; ?>)" />
                                                    </li>


                                                <?php
                                                }
                                            } else {
                                                ?>
                                                <li class="d-flex flex-column justify-content-center align-items-center 
                                    border border-1 border-secondary mb-1">
                                                    <img src="../../resources/empty_image.png" class="img-thumbnail mt-1 mb-1" />
                                                </li>
                                                <li class="d-flex flex-column justify-content-center align-items-center 
                                    border border-1 border-secondary mb-1">
                                                    <img src="../../resources/empty_image.png" class="img-thumbnail mt-1 mb-1" />
                                                </li>
                                                <li class="d-flex flex-column justify-content-center align-items-center 
                                    border border-1 border-secondary mb-1">
                                                    <img src="../../resources/empty_image.png" class="img-thumbnail mt-1 mb-1" />
                                                </li>
                                                <li class="d-flex flex-column justify-content-center align-items-center 
                                    border border-1 border-secondary mb-1">
                                                    <img src="../../resources/empty_image.png" class="img-thumbnail mt-1 mb-1" />
                                                </li>

                                            <?php
                                            }

                                            ?>

                                </ul>
                            </div>

                            <div class="col-lg-4 order-2 order-lg-1 d-none d-lg-block">
                                <div class="row">
                                    <div class="col-12 align-items-center border border-1 border-secondary">
                                        <li class="d-flex flex-column align-items-center mb-1">
                                            <img style="background-size: cover; height: 700px;" src="<?php echo $resort_data["resort_thumbnail"]; ?>" class="img-thumbnail d-flex align-items-center mt-1 mb-1" id="tnImg<?php echo $resort_data['resort_thumbnail']; ?>" onclick="loadMainImg(<?php echo $resort_data['resort_thumbnail']; ?>)" />
                                        </li>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 col-lg-6 order-3">
                                <div class="row">
                                    <div class="col-12">

                                        <div class="row">
                                            <nav aria-label="breadcrumb">
                                                <ol class="breadcrumb">
                                                    <li class="breadcrumb-item"><a href="home.php" class="fs-5">Home</a></li>
                                                    <li class="breadcrumb-item fs-5 active" aria-current="page">Single Resort View</li>
                                                </ol>
                                            </nav>
                                        </div>

                                        <div class="row">
                                            <div class="col-12 my-2">
                                                <span class="fs-3 text-dark fw-bold" style="margin-left:3%;"><?php echo $resort_data["resort_name"]; ?></span>
                                                <hr />
                                                <span class="fs-5 text-dark fw-bold" style="margin-left:5%;"><?php echo $resort_data["no"]  . " ,&nbsp; " . $resort_data["street1"] . " ,&nbsp; " . $resort_data["street2"] . " ,&nbsp " . $resort_data["city_name"] . " ,&nbsp; " . $resort_data["district_name"] . " ,&nbsp; " . $resort_data["province_name"]; ?> Province</span>
                                                <hr />
                                            </div>
                                        </div>

                                        <?php

                                            $price = number_format($resort_data["hb_double"], 2);
                                            /* $new_price = number_format(($price / 90) * 100, 2);
                                            $difference = number_format($new_price - $price, 2);
                                            $percentage = number_format(($difference / $price) * 110, 2); */


                                        ?>

                                        <div class="row">
                                            <div class="col-12 row">
                                                <div class="col-6 d-flex mb-3">
                                                    <span class="fs-4 fw-bold text-dark" style="margin-left:3%">Starting From: &nbsp; &nbsp; Rs. <?php echo $price; ?> &nbsp; &nbsp;&nbsp;&nbsp; </span>
                                                    &nbsp; &nbsp;
                                                </div>
                                                <div class="col-6 d-flex mb-3 border-start border-dark border-bold">
                                                <span class="badge" style="margin-left:3%">
                                                        <i class="bi bi-star-fill text-warning fs-6"></i>
                                                        <i class="bi bi-star-fill text-warning fs-6"></i>
                                                        <i class="bi bi-star-fill text-warning fs-6"></i>
                                                        <i class="bi bi-star-fill text-warning fs-6"></i>
                                                        <i class="bi bi-star-half text-warning fs-6"></i>

                                                        &nbsp;&nbsp;

                                                    </span>
                                                    <span class="fs-5 text-dark fw-bold">4.5 Stars | 39 Reviews & Ratings</span>
                                                </div>

                                                <hr class="mx-2"/>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-12">
                                                <ul class="fs-5 text-dark fw-bold justify-content-center" style="letter-spacing:1px;"><?php echo $resort_data["fname"]; ?> &nbsp;&nbsp; | &nbsp;&nbsp; <?php echo $resort_data["resort_mobile"]; ?></ul>
                                                <hr />
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-12">
                                                <span class="fs-4 text-primary" style="margin-left:3%">Rooms Available : <?php echo $resort_data["double"]; ?> Room(s) Available</span> <br />
                                                <hr />
                                                <?php 
                                                    $string = 'Moneyback Guarantee : 5 days Prior to Check In';
                                                ?>
                                                <span class="fs-4 text-success fw-bold" style="margin-left:3%"><?php echo strtoupper($string); ?></span> <br />
                                                <hr />
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-12">

                                                <!-- modal date error -->
                                                <div class="modal" tabindex="-1" id="bookingErrorModal">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="modalTitle"></h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body" id="modalBody">
                                                                <!-- Error message will be displayed here -->
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <!-- HTML code scheduling -->
                                                <div class="row">
                                                    <div class="col-5">
                                                        <label for="start_date" class="fw-bold">Check In:</label>
                                                        <input class="fs-5 fw-bold text-center form-control datepicker" type="date" id="start_date" name="start_date" onchange="checkOverlappingBookings();">
                                                    </div>

                                                    <div class="offset-1 col-5">
                                                        <label for="end_date" class="fw-bold">Check Out:</label>
                                                        <input class="fs-5 fw-bold text-center form-control datepicker" type="date" id="end_date" name="end_date" onchange="checkOverlappingBookings();">
                                                    </div>
                                                </div>

                                                <!-- HTML code for double rooms -->
                                                <div class="row mt-4">
                                                    <div class="col-4 d-grid">
                                                        <span>Double Rooms : &nbsp;&nbsp; <?php echo $resort_data["double"]; ?> (MAX)</span>
                                                        <input type="number" min="1" step="1" pattern="\d+" class="fs-5 fw-bold text-center form-control" pattern="[0-9]" value="0" id="booked_double" onkeyup="checkValue(<?php echo $resort_data['double'] . ', ' . $resort_data['triple'] . ', ' . $resort_data['suite']; ?>)" />
                                                    </div>
                                                    <div class="col-4">
                                                        <span>Room Type : &nbsp;&nbsp;</span>
                                                        <select class="form-select" id="db">
                                                            <option value="<?php echo $resort_data["hb_double"]; ?>">Half Board</option>
                                                            <option value="<?php echo $resort_data["fb_double"]; ?>">Full Board</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-3 d-grid">
                                                        <span>Price : &nbsp;&nbsp;</span>
                                                        <input disabled type="text" class="fs-5 fw-bold text-center form-control" value="0" id="price_display_double" />
                                                    </div>
                                                </div>

                                                <!-- HTML code for triple rooms -->
                                                <div>
                                                    <div class="row mt-4">
                                                        <div class="col-4 d-grid">
                                                            <span>Triple Rooms : &nbsp;&nbsp; <?php echo $resort_data["triple"]; ?> (MAX)</span>
                                                            <input type="number" min="1" step="1" pattern="\d+" class="fs-5 fw-bold text-center form-control" pattern="[0-9]" value="0" id="booked_triple" onkeyup="checkValue(<?php echo $resort_data['double'] . ', ' . $resort_data['triple'] . ', ' . $resort_data['suite']; ?>)" />

                                                        </div>
                                                        <div class="col-4">
                                                            <span>Room Type : &nbsp;&nbsp;</span>
                                                            <select class="form-select" id="tb">
                                                                <option value="<?php echo $resort_data["hb_triple"]; ?>">Half Board</option>
                                                                <option value="<?php echo $resort_data["fb_triple"]; ?>">Full Board</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-3 d-grid">
                                                            <span>Price : &nbsp;&nbsp;</span>
                                                            <input disabled type="text" class="fs-5 fw-bold text-center form-control" value="0" id="price_display_triple" />
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- HTML code for suite rooms -->
                                                <div>
                                                    <div class="row mt-4">
                                                        <div class="col-4 d-grid">
                                                            <span>Suite Rooms : &nbsp;&nbsp; <?php echo $resort_data["suite"]; ?> (MAX)</span>
                                                            <input type="number" min="1" step="1" pattern="\d+" class="fs-5 fw-bold text-center form-control" pattern="[0-9]" value="0" id="booked_suite" onkeyup="checkValue(<?php echo $resort_data['double'] . ', ' . $resort_data['triple'] . ', ' . $resort_data['suite']; ?>)" />

                                                        </div>
                                                        <div class="col-4">
                                                            <span>Room Type : &nbsp;&nbsp;</span>
                                                            <select class="form-select" id="sb">
                                                                <option value="<?php echo $resort_data["fb_suite"]; ?>">Full Board</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-3 d-grid">
                                                            <span>Price : &nbsp;&nbsp;</span>
                                                            <input disabled type="text" class="fs-5 fw-bold text-center form-control" value="0" id="price_display_suite" />
                                                        </div>
                                                    </div>
                                                </div>


                                                <!-- HTML code for the day price bar -->
                                                <div>
                                                    <hr> <!-- Horizontal line -->
                                                    <div class="row">
                                                        <div class="col-5">
                                                            <h4 class="text-center fw-bold">Price per day:</h4>
                                                        </div>
                                                        <div class="col-5 offset-1">
                                                            <input disabled type="text" class="fs-4 fw-bold text-end form-control" value="0" id="price_display_per_day" />
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row mt-5">

                                                    <!-- Total Price input bar -->
                                                    <div class="col-12">
                                                        <div class="row">
                                                            <div class="col-5">
                                                                <h4 class="text-center fw-bold">Total Price:</h4>
                                                            </div>
                                                            <div class="col-5 d-grid">
                                                                <input disabled type="text" class="fs-4 fw-bold text-end form-control" value="0" id="total_price" />
                                                            </div>
                                                        </div>
                                                    </div>



                                                </div>
                                                <!-- "Book Now" button -->
                                                <button class="offset-1 col-10 mt-4 btn btn-outline-success fw-bold" type="submit" id="payhere-payment" onclick="payNow(<?php echo $resort_data['resort_id']; ?>);">Book Now</button>


                                                <div class="offset-1 col-10">
                                                    <?php

                                                    $nr_rs = Database::search("SELECT * FROM `resort` 
INNER JOIN `resort_thumbnail` ON `resort`.`resort_id` = `resort_thumbnail`.`resort_id`
INNER JOIN `room_rates` ON `resort`.`resort_id` = `room_rates`.`resort_id`
INNER JOIN `resort_roomcount` ON `resort`.`resort_id` = `resort_roomcount`.`resort_id`
INNER JOIN `resort_address` ON `resort`.`resort_id` = `resort_address`.`resort_id`
INNER JOIN `city` ON `resort_address`.`city_id` = `city`.`city_id`
INNER JOIN `district` ON `city`.`district_id` = `district`.`id`
INNER JOIN `province` ON `district`.`province_id` = `province`.`id`
WHERE (`province`.`id`='" . $resort_data["province_id"] . "')
 AND `resort`.`status`='1' ORDER BY `datetime_added` DESC LIMIT 9 OFFSET 0");
                                                    $nr_num = $nr_rs->num_rows;

                                                    $wishlist_rs = Database::search("SELECT * FROM `wishlist` WHERE `wishlist`.`resort_id`='" . $resort_data["resort_id"] . "' AND
                                                                            `user_email`='" . $_SESSION["u"]["email"] . "'");
                                                    $wishlist_num = $wishlist_rs->num_rows;

                                                    if ($wishlist_num == 1) {
                                                    ?>
                                                        <button class="col-12 btn btn-outline-light mt-2 border border-danger" onclick='addToWishlist(<?php echo $resort_data["resort_id"]; ?>); window.location.reload();'">
                                                                <i class=" bi bi-heart-fill text-danger fs-5" id='heart<?php echo $resort_data["resort_id"]; ?>'></i>
                                                        </button>
                                                    <?php
                                                    } else {
                                                    ?>
                                                        <button class="col-12 btn btn-outline-light mt-2 border border-secondary" onclick='addToWishlist(<?php echo $resort_data["resort_id"]; ?>); window.location.reload();'">
                                                                <i class=" bi bi-heart-fill text-secondary fs-5" id='heart<?php echo $resort_data["resort_id"]; ?>'></i>
                                                        </button>
                                                    <?php
                                                    }


                                                    ?>
                                                </div>

                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="col-12 mt-5">
            <div class="row mx-5 mt-4 mb-4 border-bottom border-1 border-dark border-top" style="border-width: 5px !important;">
                <div class="col-12 mb-4 mt-4">
                    <span class="fs-3 fw-bold m-2">Nearby Resorts</span>
                </div>
            </div>
        </div>

        <!--nearby resorts -->
        <div class="col-12 mb-3">
            <div class="row">

                <div class="col-12">
                    <div class="row justify-content-center gap-2 mb-4">

                        <?php

                                            $nr_rs = Database::search("SELECT * FROM `resort` 
INNER JOIN `resort_thumbnail` ON `resort`.`resort_id` = `resort_thumbnail`.`resort_id`
INNER JOIN `room_rates` ON `resort`.`resort_id` = `room_rates`.`resort_id`
INNER JOIN `resort_roomcount` ON `resort`.`resort_id` = `resort_roomcount`.`resort_id`
INNER JOIN `resort_address` ON `resort`.`resort_id` = `resort_address`.`resort_id`
INNER JOIN `city` ON `resort_address`.`city_id` = `city`.`city_id`
INNER JOIN `district` ON `city`.`district_id` = `district`.`id`
INNER JOIN `province` ON `district`.`province_id` = `province`.`id`
WHERE `province`.`id`='" . $resort_data["province_id"] . "'
 AND `resort`.`status`='1' ORDER BY `datetime_added` DESC LIMIT 8 OFFSET 0");

                                            for ($z = 0; $z < $nr_num; $z++) {
                                                $nr_data = $nr_rs->fetch_assoc();

                        ?>

                            <div class="card col-6 col-lg-2 mt-2 mb-2" style="width: 18rem;">

                                <?php

                                                $image_rs = Database::search("SELECT * FROM `resort_thumbnail` WHERE `resort_id`='" . $nr_data["resort_id"] . "'");
                                                $image_data = $image_rs->fetch_assoc();

                                ?>

                                <img src="<?php echo $image_data["resort_thumbnail"]; ?>" class="card-img-top img-thumbnail mt-2" style="height: 180px;" />
                                <div class="card-body ms-0 m-0 text-center">
                                    <h5 class="card-title fs-6 fw-bold"><?php echo $nr_data["resort_name"]; ?> <span class="badge bg-success">New</span></h5>
                                    <span class="card-text text-primary">Starting From: &nbsp; $ <?php echo $nr_data["hb_double"]; ?> .00</span> <br />

                                    <?php

                                                if ($nr_data["double"] > 0 && $nr_data["triple"] && $nr_data["suite"]) {

                                    ?>

                                        <span class="card-text text-warning fw-bold">Available</span> <br />
                                        <span class="card-text text-success fw-bold"><?php echo $nr_data["double"]; ?> Double Rooms Available</span><br />
                                        <span class="card-text text-success fw-bold"><?php echo $nr_data["triple"]; ?> Triple Rooms Available</span><br />
                                        <span class="card-text text-success fw-bold"><?php echo $nr_data["suite"]; ?> Suite(s) Available</span><br /><br />
                                        <a href='<?php echo "singleresortView.php?resort_id=" . ($nr_data["resort_id"]) ?>' class="col-12 btn btn-success">Book Now</a>
                                        <button class="col-12 btn btn-danger mt-2" onclick="addToWishlist(<?php echo $nr_data['resort_id']; ?>); window.location.reload();">Add to Wishlist</button>

                                    <?php

                                                } else {

                                    ?>

                                        <span class="card-text text-warning fw-bold">Fully Booked</span><br /><br />
                                        <a class="col-12 btn disabled">Book Now</a>

                                    <?php

                                                }

                                                $wishlist_rs = Database::search("SELECT * FROM `wishlist` WHERE `resort_id`='" . $nr_data["resort_id"] . "' AND
                                                    `user_email`='" . $_SESSION["u"]["email"] . "'");
                                                $wishlist_num = $wishlist_rs->num_rows;

                                                if ($wishlist_num == 1) {
                                    ?>
                                        <button class="col-12 btn btn-outline-light mt-2 border border-info" id="btn-wish" onclick='addToWishlist(<?php echo $nr_data["resort_id"]; ?>); window.location.reload();'>
                                            <i class="bi bi-heart-fill text-danger fs-5" id='heart<?php echo $resort_data["resort_id"]; ?>'></i>
                                        </button>
                                    <?php
                                                } else {
                                    ?>
                                        <button class="col-12 btn btn-outline-light mt-2 border border-info" id="btn-wish" onclick='addToWishlist(<?php echo $nr_data["resort_id"]; ?>); window.location.reload();'>
                                            <i class="bi bi-heart-fill text-dark fs-5" id='heart<?php echo $resort_data["resort_id"]; ?>'></i>
                                        </button>
                                    <?php
                                                }

                                    ?>

                                </div>
                            </div>

                <?php

                                            }
                                        } else {
                                            echo ("Sorry for the Inconvenience");
                                        }
                                    } else {
                                        echo ("Something went wrong");
                                    }

                ?>

                    </div>
                </div>

            </div>
        </div>
        <!-- nearby resorts -->

    </div>
    </div>

    <?php include "../../footer.php"; ?>

    </div>
    </div>

    <!-- on selecting date, update room count -->
    <script>
        // Get references to the input fields and price display element for double rooms
        const qtyInput = document.querySelector('#booked_double');
        const selectedRoomType = document.querySelector('#db');
        const priceDisplayDouble = document.querySelector('#price_display_double');

        // Define the prices for Half Board and Full Board double rooms
        const hbDoublePrice = <?php echo $resort_data["hb_double"]; ?>;
        const fbDoublePrice = <?php echo $resort_data["fb_double"]; ?>;

        // Update the price when the room type or number of rooms is changed
        function updatePriceDouble() {
            const selectedPrice = selectedRoomType.value === hbDoublePrice.toString() ? hbDoublePrice : fbDoublePrice;
            const numRooms = parseInt(qtyInput.value);
            const totalPrice = selectedPrice * numRooms;
            priceDisplayDouble.value = totalPrice;
            updateDayPrice();
            updateTotalPrice();
        }

        // Listen for changes to the input fields and update the price accordingly
        qtyInput.addEventListener('change', updatePriceDouble);
        selectedRoomType.addEventListener('change', updatePriceDouble);

        // Get references to the input fields and price display element for triple rooms
        const qtyInputTriple = document.querySelector('#booked_triple');
        const roomTypeSelectTriple = document.querySelector('#tb');
        const priceDisplayTriple = document.querySelector('#price_display_triple');

        // Define the prices for Half Board and Full Board triple rooms
        const hbTriplePrice = <?php echo $resort_data["hb_triple"]; ?>;
        const fbTriplePrice = <?php echo $resort_data["fb_triple"]; ?>;

        // Update the price when the room type or number of rooms is changed for triple rooms
        function updatePriceTriple() {
            const selectedPrice = roomTypeSelectTriple.value === hbTriplePrice.toString() ? hbTriplePrice : fbTriplePrice;
            const numRooms = parseInt(qtyInputTriple.value);
            const totalPrice = selectedPrice * numRooms;
            priceDisplayTriple.value = totalPrice;
            updateDayPrice();
            updateTotalPrice();
        }

        // Listen for changes to the input fields and update the price accordingly for triple rooms
        qtyInputTriple.addEventListener('change', updatePriceTriple);
        roomTypeSelectTriple.addEventListener('change', updatePriceTriple);

        // Get references to the input fields and price display element for suite rooms
        const qtyInputSuite = document.querySelector('#booked_suite');
        const priceDisplaySuite = document.querySelector('#price_display_suite');

        // Define the price for Full Board suite rooms
        const fbSuitePrice = <?php echo $resort_data["fb_suite"]; ?>;

        // Update the price when the number of rooms is changed for suite rooms
        function updatePriceSuite() {
            const numRooms = parseInt(qtyInputSuite.value);
            const totalPrice = fbSuitePrice * numRooms;
            priceDisplaySuite.value = totalPrice;
            updateDayPrice();
            updateTotalPrice();
        }

        // Listen for changes to the input field and update the price accordingly for suite rooms
        qtyInputSuite.addEventListener('change', updatePriceSuite);

        // Get references to the price display element for day price
        const priceDisplayPerDay = document.querySelector('#price_display_per_day');

        // Update the total price when any of the room prices are changed
        function updateDayPrice() {
            const doublePrice = parseFloat(priceDisplayDouble.value) || 0;
            const triplePrice = parseFloat(priceDisplayTriple.value) || 0;
            const suitePrice = parseFloat(priceDisplaySuite.value) || 0;
            const dayPrice = doublePrice + triplePrice + suitePrice;
            priceDisplayPerDay.value = dayPrice.toFixed(2);

            const startDateInput = document.getElementById('start_date');
            const endDateInput = document.getElementById('end_date');
            const totalPriceOutput = document.getElementById('total_price');

            function calculateDays() {
                const startDate = new Date(startDateInput.value);
                const endDate = new Date(endDateInput.value);
                const oneDay = 24 * 60 * 60 * 1000;
                const diffDays = Math.round(Math.abs((endDate - startDate) / oneDay));
                return diffDays;
            }

            function calculatePrice() {
                const days = calculateDays();
                const totalPrice = dayPrice * days;
                totalPriceOutput.value = totalPrice;
            }

            startDateInput.addEventListener('change', function() {
                if (endDateInput.value) {
                    calculatePrice();
                }
            });

            endDateInput.addEventListener('change', function() {
                if (startDateInput.value) {
                    calculatePrice();
                }
            });
        }


        function updateTotalPrice() {
            const priceDisplayDoubleValue = parseInt(priceDisplayDouble.value) || 0;
            const priceDisplayTripleValue = parseInt(priceDisplayTriple.value) || 0;
            const priceDisplaySuiteValue = parseInt(priceDisplaySuite.value) || 0;
            const totalPrice = priceDisplayDoubleValue + priceDisplayTripleValue + priceDisplaySuiteValue;
            document.querySelector('#total_price').value = totalPrice;
        }
    </script>

    <script type="text/javascript" src="https://www.payhere.lk/lib/payhere.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
    <script src="../../js/script.js"></script>
</body>

</html>