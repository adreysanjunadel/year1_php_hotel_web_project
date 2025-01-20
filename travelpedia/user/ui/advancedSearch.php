<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Travelpedia | Advanced Search</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css" />
    <link rel="stylesheet" href="../../style.css" />

    <link rel="icon" href="../../resources/travelpedia.jpg" />
</head>

<body class="bg vw-100 scrollbar" style="overflow-x: hidden;">

    <?php include "header.php"; ?>

    <div class="container-fluid" style="background-image: linear-gradient(#814A3E, #1F4A5E);">
        <div class="row">


            <div class="col-12 p-5">
                <div class="row">
                    <div class="offset-lg-4 col-12 col-lg-4">
                        <div class="row">
                            <div class="col-2">
                                <div class="mt-2 mb-2 logo" style="height: 65px;"></div>
                            </div>
                            <div class="col-10 text-center">
                                <p class="fs-2 text-black-50 fw-bold mt-3 pt-2">Advanced Search</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="offset-lg-2 col-12 col-lg-8 rounded mb-2">
                <div class="row">

                    <div class="offset-lg-1 col-12 col-lg-10">
                        <div class="row">
                            <div class="col-12 col-lg-10 mt-2 mb-1">
                                <input type="text" class="form-control" placeholder="Enter Keyword to search" id="t" />
                            </div>
                            <div class="col-12 col-lg-2 mt-2 mb-1 d-grid">
                                <button class="btn btn-primary fw-bold" onclick="advancedSearch(0);">Search</button>
                            </div>
                            <div class="col-12">
                                <hr class="border border-2 border-dark" />
                            </div>
                        </div>
                    </div>

                    <div class="offset-lg-1 col-12 col-lg-10">
                        <div class="row">

                            <div class="col-12">
                                <div class="row">

                                    <div class="col-12 col-lg-4 mb-2 d-grid">
                                        <select class="form-select" id="province">
                                            <option value="0">Select Province</option>
                                            <?php
                                            require_once "../../connection.php";
                                            $province_rs = Database::search("SELECT * FROM `province`");
                                            $province_num = $province_rs->num_rows;

                                            for ($x = 0; $x < $province_num; $x++) {
                                                $province_data = $province_rs->fetch_assoc();
                                            ?>
                                                <option value="<?php echo $province_data["id"]; ?>"><?php echo $province_data["province_name"]; ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </div>

                                    <div class="col-12 col-lg-4 mb-2 d-grid">
                                        <select class="form-select" id="district">
                                            <option value="0">Select District</option>
                                            <?php
                                            $district_rs = Database::search("SELECT * FROM `district`");
                                            $district_num = $district_rs->num_rows;

                                            for ($x = 0; $x < $district_num; $x++) {
                                                $district_data = $district_rs->fetch_assoc();
                                            ?>
                                                <option value="<?php echo $district_data["id"]; ?>"><?php echo $district_data["district_name"]; ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </div>

                                    <div class="col-12 col-lg-4 mb-2 d-grid">
                                        <select class="form-select" id="city">
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

                                    <div class="col-12 col-lg-6 mb-2">
                                        <input type="number" min="1" step="1" pattern="\d+" class="form-control" placeholder="Price From...&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;($)" id="pf" />
                                    </div>

                                    <div class="col-12 col-lg-6 mb-2">
                                        <input type="number" min="1" step="1" pattern="\d+" class="form-control" placeholder="Price To...&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;($)" id="pt" />
                                    </div>

                                </div>
                            </div>

                        </div>
                    </div>

                </div>
            </div>

            <div class="offset-lg-3 col-12 col-lg-6 bg-body rounded mb-2">
                <div class="row">
                    <div class="col-2">
                        <span class="text-dark fw-bold">Filter Resorts</span>
                    </div>
                    <div class="offset-1 col-7 mt-2 mb-2 d-grid">
                        <select class="form-select border border-start-0 border-top-0 border-end-0 border-2 border-primary shadow-none" id="s">
                            <option value="0">Sort By</option>
                            <option value="1">Price High to Low</option>
                            <option value="2">Price Low to High</option>
                            <option value="3">Double Rooms High to Low</option>
                            <option value="4">Double Rooms Low to High</option>
                            <option value="5">Triple Rooms High to Low</option>
                            <option value="6">Triple Rooms Low to High</option>
                            <option value="7">Suites High to Low</option>
                            <option value="8">Suites Low to High</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="offset-lg-1 col-12 col-lg-10 rounded mb-2">
                <div class="row">
                    <div class="col-12 text-center">
                        <div class="row" id="advancedSearchArea">
                            <div class="offset-5 col-2 mt-5">
                                <span class="fw-bold text-black-50"><i class="bi bi-search" style="font-size: 100px;"></i></span>
                            </div>
                            <div class="offset-3 col-6 mt-3 mb-5">
                                <span class="h1 text-black-50 fw-bold">No Resorts Searched Yet...</span>
                            </div>
                        </div>
                    </div>
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