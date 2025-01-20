<!DOCTYPE html>

<html>

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../../style.css" />
</head>

<body>

    <div class="col-12 container-fluid">
        <div class="row">

            <nav class="navbar" style="background-image: linear-gradient(#ddffee, #eeee);">
                <div class="container-fluid">

                    <div class="col-12 col-lg-1 align-items-center logo" style="height: 40px;" onclick="window.location = 'adminDashboard.php';">
                    </div>

                    <div class="col-12 col-lg-10 align-self-end m-3">

                        <?php

                        session_start();

                        if (isset($_SESSION["au"])) {
                            $data = $_SESSION["au"];

                        ?>

                            <span class="txt-lg-start"><b>Welcome</b> <?php echo $data["fname"]; ?></span> |
                            <span class="text-lg-start fw-bold logout" onclick="window.location = 'adminLogIn.php';">Log Off</span>

                        <?php

                        } else {

                        ?>

                            <a href="adminLogin.php" class="text-decoration-none fw-bold m-2">Sign In</a> |

                        <?php


                        }

                        ?>

                    </div>

                </div>
            </nav>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
    <script src="../../js/script.js"></script>
</body>

</html>