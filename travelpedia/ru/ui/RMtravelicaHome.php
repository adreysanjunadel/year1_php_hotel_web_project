<!DOCTYPE html>

<?php

require "../../connection.php";

?>

<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Travelpedia | Resort Manager Home</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../../style.css" />

    <link rel="icon" href="../../resources/travelpedia.jpg" />
</head>

<body class="bg scrollbar" style="overflow-x: hidden;">

    <div class="container-fluid">
        <div class="row">

            <?php include "header.php"; ?>

            <hr />

            <div class="col-12 justify-content-center">
                <div class="row mb-2">

                    <div class="offset-4 offset-lg-1 col-4 col-lg-1" style="height: 65px;"></div>

                    <div class="col-12 col-lg-7">

                        <div class="input-group mt-3 mb-3">
                            <input type="text" class="form-control" placeholder="Search Your Hotel" aria-label="Search Your Resort Here" aria-describedby="button-addon2" style="border-width: 1.25pt; letter-spacing: 0.3px;" id="basic_search_text">
                            <button class="btn btn-outline-primary fw-bold" type="button" id="button-addon2" style="width: 250px; border-width: 1.25pt; letter-spacing: 0.3px;" onclick="basicSearch(0);">Search</button>
                        </div>

                    </div>

                    <div class="col-12 col-lg-2 mt-2 mt-lg-4 text-center">
                        <a href="#" class="link-dark text-decoration-none fw-bold">Advanced</a>
                    </div>

                </div>
            </div>

            <hr />

            <div class="col-12" id="basicSearchResult">
                <div class="row">

                    

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