<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>My Resort User Profile | Travelpedia </title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha1/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../../style.css" />

    <link rel="icon" href="../../resources/travelpedia.jpg" />
</head>

<body class="bg vw-100 scrollbar" style="overflow-x: hidden;">

    <div class="container-fluid">
        <div class="row">

            <?php include "ruHeader.php"; 

            if (isset($_SESSION["ru"])) {

                $ru_mail = $_SESSION["ru"]["email"];

                $rui_rs = Database::search("SELECT * FROM `resort_user` INNER JOIN `gender` ON
                `gender`.`gender_id` = `resort_user`.`gender_id` WHERE `email` ='" . $ru_mail . "' ");

                $i_rs = Database::search("SELECT * FROM `profile_images` WHERE `email` = '" . $ru_mail . "' ");

                $rui_data = $rui_rs->fetch_assoc();
                $i_data = $i_rs->fetch_assoc();

            ?>

                <div class="col-12">
                    <div class="row">

                        <div class="col-12 rounded mt-4 mb-4">
                            <div class="row g-2">

                                <div class="col-md-3 border-end">
                                    <div class="d-flex flex-column align-items-center text-center p-3 py-5">

                                        <?php

                                        if (empty($i_data["path"])) {

                                        ?>
                                            <img src="../../resources/new_user.svg" class="rounded-circle mt-5" style="width: 150px;" id="viewImg" />
                                        <?php
                                        } else {
                                        ?>
                                            <img src="<?php echo $i_data["path"]; ?>" class="rounded mt-5" style="width: 150px;" id="viewImg" />
                                        <?php
                                        }
                                        ?>

                                        <span class="fw-bold"><?php echo $rui_data["fname"] . " " . $rui_data["lname"]; ?></span>
                                        <span class="fw-bold text-black-50"><?php echo $rui_data["email"]; ?></span>

                                        <input type="file" class="d-none" id="profileimg" accept="image/*" />
                                        <label for="profileimg" class="btn btn-outline-secondary fw-bold mt-5" onclick="changeImage();">Update My Profile Image</label>

                                    </div>
                                </div>

                                <div class="col-md-5 border-end">
                                    <div class="p-3 py-5">

                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <h4 class="fw-bold">Add New Resort</h4>
                                        </div>

                                        <div class="row mt-4">

                                            <div class="col-6">
                                                <label class="form-label">First Name</label>
                                                <input type="text" class="form-control" value="<?php echo $rui_data["fname"]; ?>" id="fname" />
                                            </div>

                                            <div class="col-6">
                                                <label class="form-label">Last Name</label>
                                                <input type="text" class="form-control" value="<?php echo $rui_data["lname"]; ?>" id="lname" />
                                            </div>

                                            <div class="col-12">
                                                <label class="form-label">Mobile</label>
                                                <input type="text" class="form-control" value="<?php echo $rui_data["mobile_number"]; ?>" id="mobile" />
                                            </div>

                                            <div class="col-12">
                                                <label class="form-label">Email</label>
                                                <input type="text" class="form-control" readonly value="<?php echo $rui_data["email"]; ?>" />
                                            </div>

                                            <div class="col-12">
                                                <label class="form-label">Password</label>
                                                <div class="input-group">
                                                    <input type="password" class="form-control" readonly value="<?php echo $rui_data["password"]; ?>" />
                                                    <span class="input-group-text bg-primary" id="basic-addon2">
                                                        <i class="bi bi-eye-slash-fill text-white"></i>
                                                    </span>
                                                </div>
                                            </div>

                                            <div class="col-12">
                                                <label class="form-label">Registered Datetime</label>
                                                <input type="text" class="form-control" readonly value="<?php echo $rui_data["joined_datetime"]; ?>" />
                                            </div>

                                            <div class="col-12">
                                                <label class="form-label">Gender</label>
                                                <input type="text" class="form-control" readonly value="<?php echo $rui_data["gender_name"]; ?>" />
                                            </div>

                                            <div class="col-12 d-grid mt-3">
                                                <button class="btn btn-outline-success fw-bold" onclick="updateResortUserProfile();">Update My Profile</button>
                                            </div>

                                        </div>

                                    </div>
                                </div>

                                <div class="col-md-4 text-center">
                                    <div class="row">
                                        <span class="mt-5 fw-bold text-black-50">Custom Details</span>
                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>
                </div>

            <?php

            } else {
                header("Location:https://localhost/travelpedia/ru/uiresortUserHome.php");
            }

            ?>

            <?php include "../../footer.php" ?>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
    <script src="../../js/script.js"></script>
</body>

</html>