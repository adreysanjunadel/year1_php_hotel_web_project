<!DOCTYPE html>

<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Travelpedia | Resort User Home</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../../style.css" />

    <link rel="icon" href="../../resources/travelpedia.jpg" />
</head>

<body class="bg vw-100 scrollbar" style="overflow-x: hidden;">

    <div class="container-fluid">
        <div class="row">

            <?php include "ruHeader.php";

            ?>

            <hr />

            <div class="col-12 justify-content-center">
                <div class="row mt-2 mb-2">

                    <button class="col-12 offset-lg-2 col-lg-8 text-decoration-none text-center btn btn-outline-warning p-2" onclick="window.location='addResort.php'; ">
                        <h4 class="fw-bold p-2"><i class="fs-5 bi bi-plus-square"></i>&nbsp;&nbsp;&nbsp; Add New Resort</h4>
                    </button>

                </div>
            </div>

            <hr class="mt-4 border-400" />

            <div class="col-12">
                <div class="row">

                    <?php

                    $resort_rs = Database::search("SELECT * FROM `resort` 
                    INNER JOIN `resort_user` ON `resort_user`.`email` = `resort`.`resort_user_email`
                    INNER JOIN `resort_thumbnail` ON `resort`.`resort_id` = `resort_thumbnail`.`resort_id`
                    INNER JOIN `resort_address` ON `resort`.`resort_id` = `resort_address`.`resort_id`
                    INNER JOIN `city` ON `resort_address`.`city_id` = `city`.`city_id`
                    INNER JOIN `district` ON `city`.`district_id` = `district`.`id`
                    INNER JOIN `province` ON `district`.`province_id` = `province`.`id`
                    WHERE `resort`.`resort_user_email` = '" . $_SESSION["ru"]["email"] . "' ");
                    $resort_num = $resort_rs->num_rows;

                    for ($d = 0; $d < $resort_num; $d++) {
                        $resort_data = $resort_rs->fetch_assoc();
                    ?>

                        <div class="card col-12 offset-lg-1 col-lg-10 mt-2 mb-2">
                            <div class="d-flex">
                                <div class="card-body col-3 m-4 row">
                                    <img src="<?php echo $resort_data["resort_thumbnail"]; ?>" class="card-img-top img-fluid" placeholder="<?php echo $resort_data["resort_name"]; ?>" style="height: 180px;background-size:contain" />
                                </div>
                                <div class="card-body col-lg-6 col-12 row">
                                    <h4 class="fw-bold">
                                        <?php echo $resort_data["resort_name"]; ?>
                                    </h4>
                                    <span class="fw-bold">Resort Address: &nbsp;&nbsp;<?php echo $resort_data["no"]  . " ,&nbsp; " . $resort_data["street1"] . " ,&nbsp; " . $resort_data["street2"] . " ,&nbsp " . $resort_data["city_name"] . " ,&nbsp; " . $resort_data["district_name"] . " ,&nbsp; " . $resort_data["province_name"]; ?> Province</span>
                                    <span class="fw-bold">Availability : </span>
                                    <span class="fw-bold">Rating : </span>
                                    <span class="fw-bold">Partner Resort Since : <b> <?php echo $resort_data["datetime_added"]; ?> </b> </span>
                                </div>
                                <?php
                                if ($resort_data["status"] == 1) {
                                ?>

                                    <div class="card-body col-lg-3 col-12 row">
                                        <button class="col-lg-8 offset-lg-2 btn btn-outline-dark mt-2 mb-2 fw-bold" onclick="sendId(<?php echo $resort_data['resort_id']; ?>);">Update Resort</button>
                                        <button class="col-lg-8 offset-lg-2 btn btn-outline-info mt-2 mb-2 fw-bold" id="rb<?php echo $resort_data['resort_id']; ?>" onclick="blockResortId(<?php echo $resort_data['resort_id']; ?>);">Block Resort</button>
                                        <button class="col-lg-8 offset-lg-2 btn btn-outline-warning mt-2 mb-2 fw-bold" onclick="window.location.href='resortSchedule.php?resort_id=<?php echo $resort_data['resort_id']; ?>';">Check Resort Schedule</button>
                                    </div>
                                <?php
                                } else {
                                ?>
                                    <button class="col-lg-8 offset-lg-2 btn btn-outline-success mt-2 mb-2 fw-bold" id="rb<?php echo $sresort_data['resort_id']; ?>" onclick="blockResortId(<?php echo $resort_data['resort_id']; ?>);">Unlock Resort</button>

                                <?php
                                }
                                ?>
                            </div>
                        </div>

                    <?php
                    }
                    ?>

                </div>
            </div>

            <?php include "../../footer.php"; ?>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
    <script src="../../js/script.js"></script>
</body>

</html>