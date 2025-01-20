<!DOCTYPE html>

<?php

error_reporting(E_ALL);

?>

<html>

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../../style.css" />
</head>

<body class="container-fluid" style="overflow-x: hidden;">

    <div class="col-12">
        <div class="row">

            <nav class="navbar" style="background-color: #223843;">
                <div class="container-fluid">

                <div class="col-12 col-lg-1 mx-3 logo d-flex mt-4 mb-4" onclick="window.location = 'resortUserHome.php';"></div>

                    <div class="col-12 col-lg-1">
                        <div class="row">
                            <a class="fw-bold fs-1 text-decoration-none text-light" href="viewBookings.php"><i class="bi bi-binoculars"></i> &nbsp; <b>View Bookings</b></a> &nbsp; &nbsp;
                            &nbsp; &nbsp;
                        </div>
                    </div>

                    <div class="col-12 col-lg-7 text-end mx-5">
                    <button class="btn rounded text-light fs-4 text-center" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-title="Contact Customer Service" onclick="contactAdmin('<?php echo ($_SESSION['u']['email']); ?>');"><i class="bi bi-question-circle fs-4 fw-bold"></i>&nbsp; </button>
                        <?php
                        session_start();
                        require_once "../../connection.php";
                        if (isset($_SESSION["ru"])) {
                            $data = $_SESSION["ru"];
                            $img_rs = Database::search("SELECT * FROM `ru_profile_images` WHERE `resort_user_email` = '" . $data["email"] . "' ");
                            $img_num = $img_rs->num_rows;
                            $img_data = $img_rs->fetch_assoc();
                        ?>
                            <div class="d-inline-flex align-items-center">
                                <button class="btn btn-info border-light rounded-5">

                                <?php
                                if (empty($img_data["path"])) {
                                ?>
                                    <img src="../../resources/new_user.svg" class="rounded-circle ms-2" style="width: 48px; height: 48px;" id="viewImg" />
                                <?php
                                } else {
                                ?>
                                    <img src="<?php echo $img_data["path"]; ?>" class="rounded-circle border-rounded ms-2" style="width: 48px; height: 48px;" id="viewImg" />
                                <?php
                                }
                                ?>
                                <span class="mx-4 text-dark fw-bold"><?php echo $data["fname"] . " " . $data["lname"]; ?></span>
                                </button>
                                <span class="mx-3 text-lg-start fw-bold text-light logout" onclick="ruLogout();">Log Off</span> | &nbsp;
                                <span class="mx-3 text-lg-start text-light fw-bold">Live Support</span>
                            </div>
                        <?php
                        } else {
                        ?>
                            <a href="rmindex.php" class="text-decoration-none fw-bold ms-3">Sign In or Register</a> 
                        <?php
                        }
                        ?>
                    </div>


                    <div class="col-12 col-lg-2 dropdown">
                        <button class="col-10 btn border-dark dropdown-toggle text-light fw-100" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="background-image: linear-gradient(gray, black);">
                            My Travelpedia
                        </button>
                        <ul class="col-10 dropdown-menu" style="background-image: linear-gradient(#202C3E, #367976);">
                            <li><a class="dropdown-item" href="resortUserProfile.php"><i class="bi bi-person me-4"></i>&nbsp;My Resort User Profile</a></li>
                            <li><a class="dropdown-item" href="#"><i class="bi bi-sliders me-4"></i>&nbsp;Settings</a></li>
                        </ul>
                    </div>

                </div>
            </nav>

        </div>
    </div>

</body>

</html>