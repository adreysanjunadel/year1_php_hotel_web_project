<!DOCTYPE html>

<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="google-client-id" content="679676425412-h3cica7tipm4dlamv4dpcrt8bjjgtug5.apps.googleusercontent.com">

    <title>Travelpedia</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="styles/index.css" />

    <link rel="icon" href="resources/travelpedia.jpg" />
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet" type="text/css">
    <script src="https://accounts.google.com/gsi/client" async defer></script>
    <script src="https://apis.google.com/js/api:client.js"></script>
</head>

<body class="index-img vw-100" style="overflow-x: hidden; overflow-y: hidden;">

    <div class="container-fluid vh-100 d-flex justify-content-center">
        <div class="row align-content-center">

            <!-- header -->
            <div class="col-12 mt-4">
                <div class="row">
                    <div class="col-12 logo"></div>
                    <div class="col-12">
                        <p class="text-center title1">Hi, Welcome to Travelpedia!</p>
                    </div>
                </div>
            </div>
            <!-- header -->

            <br />

            <!-- content -->
            <div class="col-12 mt-1 p-3">
                <div class="row">

                    <div class="col-12 card rounded offset-lg-2 col-lg-8 d-block p-4" id="loginContainer">
                        <div class="row g-2">

                            <div class="col-11 mx-5">
                                <p class="title2">Login</p>
                            </div>

                            <?php

                            $email = "";
                            $password = "";

                            if (isset($_COOKIE["email"])) {
                                $email = $_COOKIE["email"];
                            }

                            if (isset($COOKIE["password"])) {
                                $password = $_COOKIE["password"];
                            }

                            ?>

                            <div class="col-11 mx-5">
                                <label class="mx-5 fs-5 text-danger fw-bold" style="font-style: italic;" id="ic">

                                </label>
                            </div>

                            <div class="col-12 col-lg-10 offset-lg-1 mt-3" id="loginEmail">
                                <label class="form-label fw-bold fs-5 d-flex">Email &nbsp; <label class="d-none fw-bold" id="starLe" style="color:red;">*</label></label>
                                <input type="email" placeholder="Enter your Email" class="form-control 6" id="usle" />
                            </div>
                            <br />
                            <div class="col-12 col-lg-10 offset-lg-1 mt-3" id="loginPass">
                                <label class="form-label fw-bold fs-5 d-flex">Password &nbsp; <label class="d-none fw-bold" id="starLp" style="color:red;">*</label></label>
                                <input type="password" placeholder="Enter your password" class="form-control 7" id="uslp" />
                            </div>
                            <br />
                            <div class="row d-flex m-4">
                                <div class="offset-1 col-5">
                                    <input class="form-check-input" type="checkbox" id="rme">
                                    <label class="form-check-label fw-bold">Remember Me</label>
                                </div>
                                <div class="offset-3 col-3">
                                    <span class="fs-6 text-danger fw-bold text-end" style="cursor: pointer" onclick="forgotPassword();">Forgot Password?</span>
                                </div>
                            </div>

                            <div class="col-12">
                                <label class="col-12 text-center fs-5 fw-bold">Don't Have an account?
                                    <a class="text-primary text-decoration-none fs-5" onclick="switchView();" style="cursor: pointer;"> Sign Up </a></label>
                            </div>

                            <br />

                            <div class="col-12 p-2 mt-2">
                                <button class="col-12 col-lg-10 offset-lg-1 btn btn-outline-dark fw-bold" onclick="login();">Login</button>
                            </div>

                            <div class="d-flex row mt-4 mb-3">
                                <hr class="offset-1 col-3" />
                                <span class="fs-5 col-4 text-center" style="color: grey; margin-top: -1%;">
                                    Or Login with </span>
                                <hr class="col-3" />
                            </div>

                            <div class="row">
                                <button class="offset-1 col-5 card border-700 rounded p-2 justify-content-center align-items-center">
                                    <img src="resources/fb.png" class="cnct-btn" />
                                </button>

                                <!-- <div class="col-5" id="g_id_onload" data-client_id="679676425412-h3cica7tipm4dlamv4dpcrt8bjjgtug5.apps.googleusercontent.com" data-callback="handleCredentialResponse" style="width: 100%; display: flex; justify-content: center;">
                                </div>
                                <div class="g_id_signin" data-type="standard" style="width: 100%;"></div> -->
                                <div class="col-5 mx-4 card border-700 rounded" id="my-signin2">
                                    <div id="g_id_onload" data-client_id="679676425412-h3cica7tipm4dlamv4dpcrt8bjjgtug5.apps.googleusercontent.com" data-callback="handleCredentialResponse" style="width: 100%;">
                                    </div>
                                    <div class="g_id_signin" style="width: 100%" data-type="standard"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card rounded col-12 offset-lg-2 col-lg-8 p-4 d-none" id="signUpContainer">
                        <div class="row">

                            <div class="col-11 mx-5">
                                <p class="title2">Create New Account</p>
                            </div>

                            <div class="col-6 offset-lg-1 col-lg-4" id="fname">
                                <label class="form-label fw-bold fs-5 d-flex" for="f">First Name &nbsp; <label class="d-none fw-bold" id="starF" style="color:red;">*</label> </label>
                                <input type="text" placeholder="Enter Your First Name" class="form-control 1" id="f" required />
                            </div>
                            <br />
                            <div class="col-6 col-lg-5 offset-lg-1" id="lname">
                                <label class="form-label fw-bold fs-5 d-flex" for="l">Last Name &nbsp; <label class="d-none fw-bold" id="starL" style="color:red;">*</label></label>
                                <input type="text" placeholder="Enter Your Last Name" class="form-control 2" id="l" />
                            </div>
                            <br />
                            <div class="col-12 col-lg-10 offset-lg-1 mt-3" id="email">
                                <label class="form-label fw-bold fs-5 d-flex" for="e">Email &nbsp; <label class="d-none fw-bold" id="starE" style="color:red;">*</label></label>
                                <input type="email" placeholder="Enter your Email. Eg. matthew@hotmail.com" class="form-control 3" id="e" />
                            </div>
                            <br />
                            <div class="col-12 col-lg-10 offset-lg-1 mt-3" id="pass">
                                <label class="form-label fw-bold fs-5 d-flex" for="p">Password <label class="fw-light fs-6 p-1"> &nbsp; Must include 1 Uppercase, 1 Lowercase, 1 Number, 1 Special Character (min 8 characters) </label> &nbsp; <label class="d-none fw-bold" id="starP" style="color:red;">*</label></label>
                                <input type="password" placeholder="Enter your password" class="form-control 4" id="p" />
                            </div>
                            <br />
                            <div class="col-6 col-lg-4 offset-lg-1 mt-3" id="mob">
                                <label class="form-label fw-bold fs-5 d-flex" for="m">Mobile &nbsp; <label class="d-none fw-bold" id="starM" style="color:red;">*</label></label>
                                <input type="text" placeholder="Enter Your Mobile Number" class="form-control 5" id="m">
                            </div>
                            <div class="col-6 col-lg-5 offset-lg-1 mt-3">
                                <label class="form-label fw-bold fs-5" for="g">Gender</label>
                                <select class="form-select" id="g">
                                    <option value="0">Select</option>
                                    <?php

                                    require "connection.php";

                                    $rs = Database::search("SELECT * FROM `gender`");
                                    $n = $rs->num_rows;

                                    for ($x = 0; $x < $n; $x++) {
                                        $d = $rs->fetch_assoc();

                                    ?>

                                        <option value="<?php echo $d["gender_id"]; ?>"><?php echo $d["gender_name"]; ?></option>

                                    <?php

                                    }

                                    ?>
                                </select>
                            </div>

                            <div class="col-12 mt-4">
                                <label class="col-12 text-center fw-bold fs-5">Have an account?
                                    <a class="text-success text-decoration-none fs-5" onclick="switchView();" style="cursor: pointer;"> Login </a></label>
                            </div>

                            <br />

                            <div class="col-12 p-2 mt-2">
                                <button class="col-12 col-lg-10 offset-lg-1 btn btn-outline-dark fw-bold" onclick="signUp();">Sign Up</button>
                            </div>

                            <div class="d-flex row mt-4 mb-3">
                                <hr class="offset-1 col-3" />
                                <span class="fs-5 col-4 text-center" style="color: grey; margin-top: -1%;">
                                    Or Sign Up with </span>
                                <hr class="col-3" />
                            </div>

                            <div class="row">
                                <button class="offset-1 col-5 card border-700 rounded p-2 justify-content-center align-items-center">
                                    <img src="resources/fb.png" class="cnct-btn" />
                                </button>
                                <button class="col-5 mx-4 card border-700 rounded p-2 justify-content-center align-items-center" id="my-signin2" onclick="startApp();">
                                    <img src="resources/gle.png" class="cnct-btn" />
                                </button>
                            </div>

                            <div class="col-12 col-lg-4 offset-lg-1 d-grid p-2">

                            </div>
                        </div>
                    </div>

                </div>

            </div>

            <!-- footer -->

            <div class="col-12 fixed-bottom d-none d-lg-block">
                <p class="text-center">&copy; travelpedia.com 2023 || All Rights Reserved</p>
            </div>

            <!-- footer -->

        </div>
    </div>
    <!-- content -->

    <!-- Account Creation Success Model -->
    <div class="modal" tabindex="-1" id="accCreationSuccessModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Account Creation Status</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p class="text-success fw-bold fs-5">Account Created Successfully ✅</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="switchView();">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Account Creation Model -->

    <!-- Existing User Modal -->
    <div class="modal" tabindex="-1" id="userExistsModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Warning</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>User account already exists</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Existing User Modal -->

    <!--Reset Password Modal -->

    <div class="modal" tabindex="-1" id="forgotPasswordModal">
        <div class="modal-dialog">
            <div class="modal-content" style="background-color: lightgray;">
                <div class="modal-header">
                    <h5 class="modal-title">Reset Password</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">

                        <div class="col-6">
                            <label class="form-label">New Password</label>
                            <div class="input-group mb-3">
                                <input type="password" class="form-control" id="npi" />
                                <button class="btn btn-secondary" type="button" id="npb" onclick="ShowPassword();"><i id="e1" class="bi bi-eye-slash-fill"></i></button>
                            </div>
                        </div>

                        <div class="col-6">
                            <label class="form-label">Re-type Password</label>
                            <div class="input-group mb-3">
                                <input type="password" class="form-control" id="rnp" />
                                <button class="btn btn-secondary" type="button" id="rnpb" onclick="ShowPassword2();"><i id="e2" class="bi bi-eye-slash-fill"></i></button>
                            </div>
                        </div>

                        <div class="col-12">
                            <label class="form-label">Verification Code</label>
                            <input type="password" class="form-control" id="vc" />
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" onclick="resetpw();">Reset Password</button>
                    </div>

                </div>
            </div>
        </div>
    </div>
    </div>

    <!-- Reset Password Modal -->

    </div>

    </div>


    <script>

    </script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
    <script src="js/script.js"></script>
    <script>
        window.onload = onLoadFocus();
    </script>
</body>

</html>