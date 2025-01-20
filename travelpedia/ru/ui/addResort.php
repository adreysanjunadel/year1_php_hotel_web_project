<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Travelpedia | Add New Resort</title>

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

                $email = $_SESSION["ru"]["email"];

                $ru_rs = Database::search("SELECT * FROM `resort`
                INNER JOIN `resort_user` ON `resort`.`resort_user_email` = `resort_user`.`email` WHERE `resort_user`.`email` = '" . $email . "'
                ");
                $ru_data = $ru_rs->fetch_assoc();

                $resort_rs = Database::search("SELECT * FROM `resort`");
                $resort_num = $resort_rs->num_rows;

                $resort_data = $resort_rs->fetch_assoc();

            ?>

                <div class="col-12">
                    <div class="row">

                        <div class="col-12 rounded mt-4 mb-4">
                            <div class="row g-2">

                                <div class="col-md-5 border-end">
                                    <div class="p-3 py-5">

                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <h4 class="col-12 col-lg-11 offset-lg-1 fw-bold mb-3">Resort Information</h4>
                                        </div>

                                        <div class="col-12 col-lg-6 offset-lg-3 rounded mt-4 mb-2 rounded">
                                            <img src="../../resources/empty_image.png" class="img-fluid border border-secondary" style="background-size: cover;" id="viewResImg" />
                                        </div>

                                        <input type="file" class="d-none" id="resImg" accept="image/*" />
                                        <label for="resImg" class="col-12 col-lg-8 offset-lg-2 btn btn-outline-secondary fw-bold mt-4" onclick="changeResThumbnailImage();">Update Resort Thumbnail Image</label>


                                        <div class="row mt-4">

                                            <div class="col-12 mt-2 mb-4">
                                                <label class="form-label">Resort Name</label>
                                                <input type="text" class="form-control" value="" id="rname" />
                                            </div>

                                            <div class="col-12 mb-4">
                                                <label class="form-label">Resort Mobile</label>
                                                <input type="text" class="form-control" value="" id="rmobile" />
                                            </div>

                                            <button class="btn btn-outline-primary fw-bold col-lg-8 offset-lg-2" onclick="addNewResort();">Save Resort Name and Mobile</button>

                                            <hr class="mt-4 mb-4" />

                                            <div class="col-12 col-lg-11 offset-lg-1">
                                                <label class="form-label fw-bold align-items-center mb-3" style="font-size: 20px;">Add Resort Address Details</label>
                                            </div>

                                            <div class="col-8 offset-2 mb-4" id="resort_id_container">
                                                <label class="form-label">Resort ID</label>
                                                <input type="number" min="1" step="1" pattern="\d+" class="form-control" id="ra-id" />
                                            </div>

                                            <div class="col-12 mb-4">
                                                <label class="form-label">Address Number</label>
                                                <input type="text" class="form-control" id="ra-no" />
                                            </div>

                                            <div class="col-6 mb-4">
                                                <label class="form-label">Address Street 1</label>
                                                <input type="text" class="form-control" id="ra-street1" />
                                            </div>

                                            <div class="col-6 mb-4">
                                                <label class="form-label">Address Street 2</label>
                                                <input type="text" class="form-control" id="ra-street2" />
                                            </div>

                                            <div class="col-12 mb-4">
                                                <label class="form-label">City</label>
                                                <select class="form-select" id="ra-city">
                                                    <option value="0">Select City</option>
                                                    <?php
                                                    $city_rs = Database::search("SELECT * FROM `city`");
                                                    $city_num = $city_rs->num_rows;
                                                    for ($x = 0; $x < $city_num; $x++) {
                                                        $city_data = $city_rs->fetch_assoc();
                                                    ?>
                                                        <option value="<?php echo $city_data["city_id"]; ?>"><?php echo $city_data["city_name"]; ?></option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>

                                            <div class="col-12 d-grid mt-4">
                                                <button class="btn btn-outline-success fw-bold" onclick="addResortAddress();">Add Resort to System</button>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-7 col-12">
                                    <div class="p-3 py-5">

                                        <div class="col-12 col-lg-11 offset-lg-1">
                                            <label class="form-label fw-bold align-items-center mb-3" style="font-size: 20px;">Add Resort Images</label>
                                        </div>

                                        <label class="form-label fw-bold offset-lg-2">Add Images Here</label>


                                        <div class="col-12 mt-4">
                                            <div class="d-flex">
                                                <div class="col-12 col-lg-3 rounded mt-4 mb-2" style="margin:2.5%; width:17.5%;">
                                                    <img src="../../resources/empty_image.png" class="img-fluid border border-secondary rounded" style="background-size: contain;" id="ri0" />
                                                </div>
                                                <div class="col-12 col-lg-3 rounded mt-4 mb-2" style="margin:2.5%; width:17.5%">
                                                    <img src="../../resources/empty_image.png" class="img-fluid border border-secondary rounded" style="background-size: contain;" id="ri1" />
                                                </div>
                                                <div class="col-12 col-lg-3 rounded mt-4 mb-2" style="margin:2.5%; width:17.5%">
                                                    <img src="../../resources/empty_image.png" class="img-fluid border border-secondary rounded" style="background-size: contain;" id="ri2" />
                                                </div>
                                                <div class="col-12 col-lg-3 rounded mt-4 mb-2" style="margin:2.5%; width:17.5%;">
                                                    <img src="../../resources/empty_image.png" class="img-fluid border border-secondary rounded" style="background-size: contain;" id="ri3" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-8 offset-2 mb-2" id="resort_id_container">
                                        <label class="form-label" id="rii">Resort ID</label>
                                        <input type="number" min="1" step="1" pattern="\d+" class="form-control" value="" id="rin" />

                                    </div>

                                    <div class="col-12 ">
                                        <div class="d-flex">
                                            <input type="file" class="d-none" id="res-imguploader" multiple />
                                            <label for="res-imguploader" class="col-12 col-md-4 offset-md-2 btn btn-outline-dark fw-bold mt-4 mb-4 row" style="width:30%" onclick="changeResImage();">Upload Images</label>
                                            <button class="col-12 col-md-4 offset-md-1 btn btn-outline-warning fw-bold mt-4 mb-4 row" style="width:30%" onclick="addResortImages();">Confirm</button>
                                        </div>
                                    </div>

                                    <hr style="width:95%; margin-left:2.5%;" class="mt-2 mb-2" />

                                    <div class="d-flex justify-content-between align-items-center mb-3 mt-4">
                                        <h4 class="col-12 col-lg-11 offset-lg-1 fw-bold mb-3">Room Information</h4>
                                    </div>

                                    <div class="col-8 offset-2 mb-2" id="resort_id_container">
                                        <label class="form-label" id="rri">Resort ID</label>
                                        <input type="number" min="1" step="1" pattern="\d+" class="form-control" value="" id="rrn" />
                                    </div>

                                    <div class="row mt-4">
                                        <div class="col-12 mt-2 mb-4">
                                            <h5 class="offset-lg-1 mb-2 fw-bold mb-3">Double Rooms</h5>
                                            <div class="d-flex mx-5">
                                                <label class="form-label col-lg-3">
                                                    Room Count
                                                    <input type="number" min="1" step="1" pattern="\d+" class="form-control" value="0" id="drc" />
                                                </label>
                                                <label class="form-label col-lg-3 offset-lg-1">
                                                    Half Board Room Rate ($) / day
                                                    <input type="number" min="1" step="1" pattern="\d+" class="form-control" value="0" id="hdr" />
                                                </label>
                                                <label class="form-label col-lg-3 offset-lg-1">
                                                    Full Board Room Rate ($) / day
                                                    <input type="number" min="1" step="1" pattern="\d+" class="form-control" value="0" id="fdr" />
                                                </label>
                                            </div>
                                        </div>

                                        <div class="col-12 mt-2 mb-4">
                                            <h5 class="offset-lg-1 mb-2 fw-bold mb-3">Triple Rooms</h5>
                                            <div class="d-flex mx-5">
                                                <label class="form-label col-lg-3">
                                                    Room Count
                                                    <input type="number" min="1" step="1" pattern="\d+" class="form-control" value="0" id="trc" />
                                                </label>
                                                <label class="form-label col-lg-3 offset-lg-1">
                                                    Half Board Room Rate ($) / day
                                                    <input type="number" min="1" step="1" pattern="\d+" class="form-control" value="0" id="htr" />
                                                </label>
                                                <label class="form-label col-lg-3 offset-lg-1">
                                                    Full Board Room Rate ($) / day
                                                    <input type="number" min="1" step="1" pattern="\d+" class="form-control" value="0" id="ftr" />
                                                </label>
                                            </div>
                                        </div>

                                        <div class="col-12 mt-2 mb-4">
                                            <h5 class="offset-lg-1 mb-2 fw-bold mb-3">Suites</h5>
                                            <div class="d-flex mx-5">
                                                <label class="form-label col-lg-3">
                                                    Room Count
                                                    <input type="number" min="1" step="1" pattern="\d+" class="form-control" value="0" id="src" />
                                                </label>
                                                <label class="form-label col-lg-3 offset-lg-1">
                                                    Half Board Room Rate ($) / day
                                                    <input type="number" min="1" step="1" pattern="\d+" class="form-control" value="0" id="hsr" />
                                                </label>
                                                <label class="form-label col-lg-3 offset-lg-1">
                                                    Full Board Room Rate ($) / day
                                                    <input type="number" min="1" step="1" pattern="\d+" class="form-control" value="0" id="fsr" />
                                                </label>
                                            </div>
                                        </div>

                                        <button class="col-lg-8 offset-lg-2 btn btn-outline-danger fw-bold" onclick="addResortRoomRates();">Add Resort Room Rates</button>

                                    </div>

                                </div>
                            </div>

                        </div>
                    </div>

                </div>
        </div>

    <?php
            } else {
                header("Location:https://localhost/travelpedia/ru/ui/resortUserHome.php");
            }
    ?>

    <?php include "../../footer.php"; ?>

    </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
    <script src="../../js/script.js"></script>
</body>

</html>