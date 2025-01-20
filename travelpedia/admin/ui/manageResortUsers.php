<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Manage Resort Users | Travelpedia</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css" />
    <link rel="stylesheet" href="../../style.css" />

    <link rel="icon" href="../../resources/travelpedia.jpg" />
</head>

<body class="bg scrollbar" style="overflow-x: hidden;">

    <div class="container-fluid">
        <div class="row">

            <?php include "adminHeader.php";
            require "../../connection.php";
            $mail = $_SESSION["au"]["email"];
            ?>

            <div class="col-12 col-lg-2 align-items-start bg-info vh-100">
                <div class="row g-1 text-center">

                    <div class="col-12 mt-5">
                        <h4 class="text-white"><?php echo $_SESSION["au"]["fname"] . " " . $_SESSION["au"]["lname"]; ?></h4>
                        <hr class="border border-1 border-white" />
                    </div>
                    <div class="col-12">
                        <hr class="border border-1 border-white" />
                        <h4 class="text-white fw-bold">User Provisioning</h4>
                        <hr class="border border-1 border-white" />
                    </div>
                    <div class="nav flex-column nav-pills p-2" role="tablist" aria-orientation="vertical">
                        <nav class="nav flex-column">
                            <a class="nav-link" href="adminDashboard.php">Dashboard</a>
                            <a class="nav-link" href="manageUsers.php">Manage Users</a>
                            <a class="nav-link active" aria-current="page" href="manageResortUsers.php">Manage Resort Users</a>
                            <a class="nav-link" href="manageResorts.php">Manage Resorts</a>
                        </nav>
                    </div>
                    <div class="col-12">
                        <hr class="border border-1 border-white" />
                        <h4 class="text-white fw-bold">Daily Bookings</h4>
                        <hr class="border border-1 border-white" />
                    </div>
                    <div class="nav flex-column nav-pills p-2" role="tablist" aria-orientation="vertical">
                        <nav class="nav flex-column">
                            <a class="nav-link" href="checkDailyBookings.php">View Daily Bookings</a>
                        </nav>
                    </div>
                    <div class="col-12">
                        <hr class="border border-1 border-white" />
                        <h4 class="text-white fw-bold">Invoices</h4>
                        <hr class="border border-1 border-white" />
                    </div>
                    <div class="nav flex-column nav-pills p-2" role="tablist" aria-orientation="vertical">
                        <nav class="nav flex-column">
                            <a class="nav-link" href="searchInvoices.php">Search Invoices</a>
                            <a class="nav-link disabled" href="#">View Invoice</a>
                        </nav>
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-10">
                <div class="row">

                    <div class="text-white fw-bold mb-1 mt-3">
                        <h2 class="fw-bold text-dark m-4">Manage Resort Users</h2>
                    </div>
                    <div class="col-12">
                        <hr />
                    </div>
                    <div class="col-12">
                        <div class="row g-1">

                            <div class="col-12 mt-3">
                                <div class="row">
                                    <div class="offset-0 offset-lg-3 col-12 col-lg-6 mb-3">
                                        <div class="row">
                                            <div class="col-12">
                                                <input type="text" class="form-control" id="resortUserSearchText" placeholder="Type to display specific results" onkeyup="resortSearchUser(0);" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12" id="resortUserSearchResult">
                                <hr />
                                <?php

                                $query = "SELECT * FROM `resort_user` ";
                                $pageno;

                                if (isset($_GET["page"])) {
                                    $pageno = $_GET["page"];
                                } else {
                                    $pageno = 1;
                                }

                                $user_rs = Database::search($query);
                                $user_num = $user_rs->num_rows;

                                $results_per_page = 4;
                                $number_of_pages = ceil($user_num / $results_per_page);

                                $page_results = ($pageno - 1) * $results_per_page;
                                $selected_rs =  Database::search($query . " LIMIT " . $results_per_page . " OFFSET " . $page_results . "");

                                $selected_num = $selected_rs->num_rows;

                                for ($x = 0; $x < $selected_num; $x++) {
                                    $selected_data = $selected_rs->fetch_assoc();

                                ?>
                                    <div class="row mt-4 align-items-center">
                                        <div class="card col-10 offset-1">
                                            <div class="card-body">
                                                <h4 class="card-title fw-bold"><?php echo $selected_data["fname"] . " " . $selected_data["lname"]; ?></h4>
                                                <p class="card-text">Joined in <?php echo $selected_data["joined_datetime"]; ?>
                                                    <br />

                                                    <?php
                                                    if ($selected_data["status"] == 1) {
                                                    ?>
                                                <div class="row mt-4">
                                                    <button class="col-10 offset-1 btn btn-outline-dark" id="rub<?php echo $selected_data['email']; ?>" class="btn btn-danger" onclick="blockResortUser('<?php echo $selected_data['email']; ?>');">Block Resort User</button>
                                                </div>
                                            <?php
                                                    } else {
                                            ?>
                                                <button id="rub<?php echo $selected_data['email']; ?>" class="col-10 offset-1 btn btn-outline-success" onclick="blockResortUser('<?php echo $selected_data['email']; ?>');">Unblock Resort User</button>
                                            <?php

                                                    }

                                            ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php
                                }
                                ?>
                                <!--  -->
                                <div class="row mt-4">
                                    <div class="offset-3 col-6 text-center mb-3">
                                        <nav aria-label="Page navigation example">
                                            <ul class="pagination pagination-lg justify-content-center">
                                                <li class="page-item">
                                                    <a class="page-link" href="
                                                <?php if ($pageno <= 1) {
                                                    echo ("#");
                                                } else {
                                                    echo "?page=" . ($pageno - 1);
                                                } ?>
                                                " aria-label="Previous">
                                                        <span aria-hidden="true">&laquo;</span>
                                                    </a>
                                                </li>
                                                <?php

                                                for ($x = 1; $x <= $number_of_pages; $x++) {
                                                    if ($x == $pageno) {
                                                ?>
                                                        <li class="page-item active">
                                                            <a class="page-link" href="<?php echo "?page=" . ($x); ?>"><?php echo $x; ?></a>
                                                        </li>
                                                    <?php
                                                    } else {
                                                    ?>
                                                        <li class="page-item">
                                                            <a class="page-link" href="<?php echo "?page=" . ($x); ?>"><?php echo $x; ?></a>
                                                        </li>
                                                <?php
                                                    }
                                                }

                                                ?>

                                                <li class="page-item">
                                                    <a class="page-link" href="
                                                <?php if ($pageno >= $number_of_pages) {
                                                    echo ("#");
                                                } else {
                                                    echo "?page=" . ($pageno + 1);
                                                } ?>
                                                " aria-label="Next">
                                                        <span aria-hidden="true">&raquo;</span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </nav>
                                    </div>
                                </div>
                                <!--  -->

                            </div>
                        </div>

                    </div>
                </div>


            </div>


        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
<script src="../../js/script.js"></script>
</body>