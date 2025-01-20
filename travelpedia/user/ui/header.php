<!DOCTYPE html>

<html>

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../../style.css" />
</head>

<body>

    <div class="col-12 container-fluid header">
        <div class="row">

            <nav class="navbar" style="background-color: #223843;">
                <div class="container-fluid">

                    <div class="col-12 offset-lg-1 col-lg-10 mb-3">
                        <div class="row">
                            <div class="col-12 col-lg-2 logo d-flex mt-3 mb-2" onclick="window.location = 'home.php';"></div>
                            <div class="col-12 col-lg-10 p-2 d-flex justify-content-end mt-3">

                                <?php

                                require "../../connection.php";

                                session_start();

                                if (isset($_SESSION["u"])) {
                                    $data = $_SESSION["u"];

                                ?>

                                    <div class="mt-2 mb-2">
                                        <button class="btn rounded text-light fs-4 text-center" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-title="Contact Customer Service" onclick="contactAdmin('<?php echo ($_SESSION['u']['email']); ?>');"><i class="bi bi-question-circle fs-4 fw-bold"></i>&nbsp; </button>
                                        <span class="fs-4 txt-lg-end text-light"><b class="fs-4"> &nbsp; Welcome</b> <?php echo $data["fname"]; ?> &nbsp; <?php echo $data["lname"]; ?> &nbsp; |</span>
                                        <button class="btn rounded text-light fs-4 text-lg-end text-center" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-title="Logout" onclick="logOut();">&nbsp;&nbsp;<i class="bi bi-box-arrow-left fs-4 fw-bold"></i></span>
                                    </div>


                                <?php

                                } else {

                                ?>

                                    <a href="../../index.php" class="text-decoration-none text-light fs-4 text-lg-end mt-4 mb-4">Sign In or Register</a>

                                <?php


                                }

                                ?>
                            </div>
                        </div>

                        <div class="row mt-2 mb-1">
                            <?php
                            $current_page = basename($_SERVER['REQUEST_URI']);
                            ?>

                            <div class="col-2 mt-2 d-flex mx-2">
                                <button class="col-2 btn-hotels hotels border border-light text-light" onclick="window.location='home.php'">
                                    <i class="bi bi-houses fs-4"></i> &nbsp; Hotels
                                </button>
                            </div>

                            <div class="col-2 d-flex mt-2 mx-2">
                                <button class="col-2 btn-hotels hotels border border-light text-light" <?php echo ($current_page == 'deals.php') ? 'disabled' : 'onclick="window.location=\'deals.php\'"' ?>>
                                    <i class="bi bi-hand-thumbs-up"></i> &nbsp; Deals
                                </button>
                            </div>

                            <div class="col-2 d-flex mt-2 mx-2">
                                <button class="col-2 btn-hotels hotels border border-light text-light" <?php echo ($current_page == 'bookingHistory.php') ? 'disabled' : 'onclick="window.location=\'bookingHistory.php\'"' ?>>
                                    <i class="bi bi-clock"></i> &nbsp; Booking History
                                </button>
                            </div>

                            <div class="col-2 d-flex mt-2 mx-2">
                                <button class="col-2 btn-hotels hotels border border-light text-light" <?php echo ($current_page == 'bookingSchedule.php') ? 'disabled' : 'onclick="window.location=\'bookingSchedule.php\'"' ?>>
                                    <i class="bi bi-calendar4-week"></i> &nbsp; Booking Schedule
                                </button>
                            </div>

                            <div class="col-12 col-lg-2 offset-lg-10 dropdown mt-2 mb-4">
                                <button class="btn dropdown-toggle text-light fw-100" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="background-image: linear-gradient(#202C3E, #367976);">
                                    My Travelpedia
                                </button>
                                <ul class="dropdown-menu dropdown-menu-dark">
                                    <li><a class="dropdown-item" href="customerProfile.php">My Profile</a></li>
                                    <li><a class="dropdown-item" href="message.php">Messages</a></li>
                                </ul>
                            </div>
                        </div>

                    </div>


                </div>

            </nav>
        </div>
    </div>

    <!-- msg modal start -->

    <div class="modal" tabindex="-1" id="contactAdmin">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="bi bi-info-lg fs-3"></i>Customer Service</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="msg_box2<?php echo $admin ?>" style="height: 300px; overflow-y: scroll;">
                    <?php

                    require_once "../../connection.php";

                    $msg_rs = Database::search("SELECT * FROM `chat` WHERE `from`='" . $_SESSION["u"]["email"] . "' OR `to`= '" . $_SESSION["u"]["email"] . "' ");
                    $msg_num = $msg_rs->num_rows;
                    for ($y = 0; $y < $msg_num; $y++) {
                        $msg_data = $msg_rs->fetch_assoc();
                        if ($msg_data["to"] == $_SESSION["u"]["email"]) {

                    ?>
                            <!-- received start -->
                            <div class="col-12 mt-2">
                                <div class="row">
                                    <div class="col-8 rounded bg-success">
                                        <div class="row">
                                            <div class="col-12 pt-2">
                                                <span class="text-white fw-bold fs-4"><?php echo $msg_data["content"]; ?></span>
                                            </div>
                                            <div class="col-12 text-end pb-2">
                                                <span class="text-white fs-6"><?php echo $msg_data["date_time"]; ?></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- received end -->
                        <?php
                        }

                        if ($msg_data["from"] == $_SESSION["u"]["email"]) {

                        ?>
                            <!-- sent start -->

                            <div class="col-12 mt-2">
                                <div class="row">
                                    <div class="offset-4 col-8 rounded bg-primary">
                                        <div class="row">
                                            <div class="col-12 pt-2">
                                                <span class="text-white fw-bold fs-4"><?php echo $msg_data["content"]; ?></span>
                                            </div>
                                            <div class="col-12 text-end pb-2">
                                                <span class="text-white fs-6"><?php echo $msg_data["date_time"]; ?></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- sent end -->
                    <?php
                        }
                    }
                    ?>
                </div>

                <div class="modal-footer">
                    <div class="col-12">
                        <div class="row">
                            <div class="col-9">
                                <input type="text" class="form-control" id="msgtxt<?php echo $admin; ?>" />
                            </div>
                            <div class="col-3 d-grid">
                                <button type="button" class="btn btn-primary" onclick="sendAdminMessage('<?php echo $admin; ?>');">Send</button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- msg modal end -->


    </div>
    </div>
</body>


</html>