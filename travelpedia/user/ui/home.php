<!DOCTYPE html>

<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Travelpedia | Home</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../../style.css" />

    <link rel="icon" href="../../resources/travelpedia.jpg" />

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>
</head>

<body class="bg vw-100 scrollbar" style="position: relative; overflow-x: hidden;">

    <div class="container-fluid">
        <div class="row mb-3">

            <?php
            include "homeHeader.php";
            ?>

            <div class="col-12">
                <div class="row" style="margin-top: -60px; position: relative; width: 100vw;">

                    <div class="offset-1 offset-lg-2 col-8 col-lg-5">
                        <div class="input group mt-lg-3 mb-lg-3 d-flex border border-primary rounded search">
                            <span class="input-group-text" id="addon-wrapping">
                                <i class="bi bi-houses fs-5 p-2 mx-5"></i>
                            </span>
                            <input type="text" class="form-control fs-5" aria-label="Text input with dropdown button" id="basic_search_text">

                            <select class="form-select row col-12 fs-5 fw-bold" style="max-width: 25%;" id="basic_search_select">
                                <option class="fs-5" value="0">All Provinces</option>
                                <?php

                                $prov_rs = Database::search("SELECT * FROM `province`");
                                $prov_num = $prov_rs->num_rows;

                                for ($p = 0; $p < $prov_num; $p++) {
                                    $prov_data = $prov_rs->fetch_assoc();
                                ?>

                                    <option class="fs-5" value="<?php echo $prov_data["id"]; ?>"><?php echo $prov_data["province_name"]; ?></option>
                                <?php
                                }
                                    
                                ?>
                            </select>
                            
                        </div>
                    </div>

                    <div class="col-12 col-lg-2 d-grid">
                        <button class="btn btn-dark fs-5 fw-bold mt-3 mb-3" onclick="basicSearch(0);">Search</button>
                    </div>
                    <div class="col-12 col-lg-1 mt-3 text-center">
                        <a href="#" class="fs-4 border border-light link-light text-decoration-none fw-bold btn-search p-3 rounded-5" onclick="window.location = 'advancedSearch.php'">Advanced Search</a>
                    </div>

                </div>
                <img src="../../resources/divider.png" style="width: 100%; height:280px; z-index: 2; margin-top: -37px; margin-bottom: -22px;" />
            </div>

            <br />

            <div class="col-12 row d-flex justify-content-center" style="background-image: linear-gradient(#814A3E, #1F4A5E);">
                <div class="card d-grid col-2 mx-5 mt-5">
                    <ul class="list-group list-group-flush">

                        <?php
                        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action'])) {
                            if ($_POST['action'] == 'getDistricts' && isset($_POST['province_id'])) {
                                $selected_province = intval($_POST['province_id']);
                                $district_rs = Database::search("SELECT * FROM `district` WHERE `province_id` = $selected_province");
                        
                                while ($district_data = $district_rs->fetch_assoc()) {
                                    echo '<option value="' . $district_data["id"] . '">' . $district_data["district_name"] . '</option>';
                                }
                                exit;
                            }
                        
                            if ($_POST['action'] == 'getCities' && isset($_POST['district_id'])) {
                                $selected_district = intval($_POST['district_id']);
                                $city_rs = Database::search("SELECT * FROM `city` WHERE `district_id` = $selected_district");
                        
                                while ($city_data = $city_rs->fetch_assoc()) {
                                    echo '<option value="' . $city_data["city_id"] . '">' . $city_data["city_name"] . '</option>';
                                }
                                exit;
                            }
                        }
                        ?>

                        <li class="list-group-item fs-4 fw-bold p-3">Filter By</li>
                        <form method="post" action="home.php">
                            <li class="list-group-item mt-1">
                                <span class="fs-5 fw-bold mx-2">Location</span>
                                <div class="row">
                                    <div class="col-4 p-3">
                                        <span class="fw-bold">Province</span>
                                    </div>
                                    <div class="col-8 p-2 justify-content-center align-items-center">
                                        <select class="form-select scrollbar" id="province" name="province">
                                            <option value="0">Select Province</option>
                                            <?php
                                            $province_rs = Database::search("SELECT * FROM `province`");
                                            while ($province_data = $province_rs->fetch_assoc()) {
                                                echo '<option value="' . $province_data["id"] . '">' . $province_data["province_name"] . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-4 p-3">
                                        <span class="fw-bold">District</span>
                                    </div>
                                    <div class="col-8 p-2">
                                        <select class="form-select scrollbar" id="district" name="district">
                                            <option value="0">Select District</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-4 p-3">
                                        <span class="fw-bold">City</span>
                                    </div>
                                    <div class="col-8 p-2">
                                        <select class="form-select scrollbar" id="city" name="city">
                                            <option value="0">Select City</option>
                                        </select>
                                    </div>
                                </div>
                            </li>
                        </form>

                        <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                const provinceSelect = document.getElementById('province');
                                const districtSelect = document.getElementById('district');
                                const citySelect = document.getElementById('city');

                                const clearOptions = (selectElement) => {
                                    while (selectElement.options.length > 1) {
                                        selectElement.remove(1);
                                    }
                                };

                                const fetchOptions = (action, id, targetSelect) => {
                                    fetch('home.php', {
                                            method: 'POST',
                                            headers: {
                                                'Content-Type': 'application/x-www-form-urlencoded',
                                            },
                                            body: new URLSearchParams({
                                                action: action,
                                                province_id: action === 'getDistricts' ? id : null,
                                                district_id: action === 'getCities' ? id : null
                                            })
                                        })
                                        .then(response => response.text())
                                        .then(data => {
                                            targetSelect.innerHTML += data;
                                        })
                                        .catch(error => {
                                            console.error('Error:', error);
                                        });
                                };

                                provinceSelect.addEventListener('change', function() {
                                    const provinceId = this.value;
                                    clearOptions(districtSelect);
                                    clearOptions(citySelect);

                                    if (provinceId === '0') return;

                                    fetchOptions('getDistricts', provinceId, districtSelect);
                                });

                                districtSelect.addEventListener('change', function() {
                                    const districtId = this.value;
                                    clearOptions(citySelect);

                                    if (districtId === '0') return;

                                    fetchOptions('getCities', districtId, citySelect);
                                });
                            });
                        </script>

                        <li class="list-group-item">
                            <div id="chartContainer" style="height: 320px;"></div>
                            <div class="slider-container">
                                <!-- Custom Range Slider -->
                                <div class="slider-track">
                                    <div class="slider-selection"></div>
                                    <div class="slider-handle min"></div>
                                    <div class="slider-handle max"></div>
                                </div>
                            </div>
                            <div class="form-container">
                                <div class="row mt-2" id="graphForm">
                                    <div class="col-5">
                                        <input class="form-control" type="number" id="minData" name="minData" value="0" required>
                                    </div>
                                    <div class="col-2 p-2 fw-bold text-center">to</div>
                                    <div class="col-5">
                                        <input class="col-4 form-control" type="number" id="maxData" name="maxData" value="100" required>
                                    </div>
                                </div>
                            </div>

                            <?php
                            // Define your data here (replace with your actual dynamic data or fetch from database)
                            $data = array(
                                array("x" => 1, "y" => 3),
                                array("x" => 2, "y" => 6),
                                array("x" => 3, "y" => 4),
                                array("x" => 4, "y" => 8),
                                array("x" => 5, "y" => 2),
                                array("x" => 6, "y" => 9),
                                array("x" => 7, "y" => 17),
                                array("x" => 8, "y" => 13),
                                // ... more data points
                            );

                            // Construct Highcharts options
                            $chartOptions = array(
                                "chart" => array(
                                    "type" => "column",
                                    "renderTo" => "chartContainer",
                                    "backgroundColor" => "transparent",
                                    "height" => 320,
                                ),
                                "title" => array(
                                    "text" => "Travelpedia",
                                    "style" => array(
                                        "color" => "white"
                                    )
                                ),
                                "xAxis" => array(
                                    "type" => "category",
                                    "labels" => array(
                                        "style" => array(
                                            "color" => "white"
                                        )
                                    )
                                ),
                                "yAxis" => array(
                                    "title" => array(
                                        "text" => "Data Values",
                                        "style" => array(
                                            "color" => "white"
                                        )
                                    ),
                                    "labels" => array(
                                        "style" => array(
                                            "color" => "white"
                                        )
                                    )
                                ),
                                "plotOptions" => array(
                                    "column" => array(
                                        "pointPadding" => 0.1,
                                        "borderWidth" => 0
                                    )
                                ),
                                "series" => array(
                                    array(
                                        "name" => "Data",
                                        "data" => $data,
                                        "color" => "#00FF00"
                                    )
                                )
                            );

                            // Convert chart options to JSON
                            $chartOptionsJSON = json_encode($chartOptions);
                            ?>

                            <style>
                                .slider-container {
                                    position: relative;
                                    width: 100%;
                                    margin-top: 20px;
                                }

                                .slider-track {
                                    position: relative;
                                    width: 100%;
                                    height: 10px;
                                    background: #444444;
                                    border-radius: 5px;
                                    overflow: hidden;
                                }

                                .slider-selection {
                                    position: absolute;
                                    background-color: rgba(0, 255, 0, 0.3);
                                    height: 100%;
                                    z-index: 0;
                                }

                                .slider-handle {
                                    position: absolute;
                                    width: 20px;
                                    height: 20px;
                                    background-color: #00FF00;
                                    border: 2px solid #FFFFFF;
                                    border-radius: 50%;
                                    transition: background-color 0.15s ease-in-out;
                                    cursor: pointer;
                                    z-index: 1;
                                    box-shadow: 0 0 10px rgba(0, 255, 0, 0.7);
                                }

                                .slider-handle.min {
                                    left: 0;
                                    transform: translateX(-50%);
                                }

                                .slider-handle.max {
                                    right: 0;
                                    transform: translateX(50%);
                                }
                            </style>

                            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                            <script src="https://code.highcharts.com/highcharts.js"></script>
                            <script>
                                document.addEventListener("DOMContentLoaded", function() {
                                    var chartOptions = <?php echo $chartOptionsJSON; ?>;
                                    var chart = new Highcharts.Chart(chartOptions);

                                    // Function to update chart based on slider and input values
                                    function updateChart() {
                                        var minData = parseInt($('#minData').val());
                                        var maxData = parseInt($('#maxData').val());

                                        var newData = <?php echo json_encode($data); ?>.map(function(point, index) {
                                            var isActive = (index + 1 >= minData && index + 1 <= maxData); // Adjusted to match your 1-based x values
                                            return {
                                                x: point.x,
                                                y: isActive ? point.y : 0,
                                                color: isActive ? '#00FF00' : '#444444'
                                            };
                                        });

                                        chart.series[0].setData(newData);
                                    }

                                    // Initial update
                                    updateChart();

                                    // Handle slider input
                                    $('.slider-handle').on('mousedown touchstart', function(event) {
                                        var handle = $(this);
                                        var isMinHandle = handle.hasClass('min');
                                        var isMaxHandle = handle.hasClass('max');
                                        var sliderTrack = handle.parent('.slider-track');
                                        var sliderWidth = sliderTrack.width();
                                        var sliderStart = sliderTrack.offset().left;
                                        var sliderEnd = sliderStart + sliderWidth;

                                        $(document).on('mousemove touchmove', function(event) {
                                            var mouseX = event.pageX || event.originalEvent.touches[0].pageX;
                                            var newPosition = mouseX - sliderStart;

                                            // Ensure handles stay within bounds
                                            newPosition = Math.max(0, Math.min(newPosition, sliderWidth));

                                            // Update handle position
                                            handle.css('left', newPosition);

                                            // Update min and max values
                                            var minPosition = $('.slider-handle.min').position().left;
                                            var maxPosition = $('.slider-handle.max').position().left;

                                            var minPercent = minPosition / sliderWidth * 100;
                                            var maxPercent = maxPosition / sliderWidth * 100;

                                            $('#minData').val(Math.round(minPercent));
                                            $('#maxData').val(Math.round(maxPercent));

                                            // Update chart
                                            updateChart();
                                        });

                                        $(document).on('mouseup touchend', function() {
                                            $(document).off('mousemove touchmove');
                                        });

                                        event.preventDefault();
                                    });

                                    // Handle min and max input changes
                                    $('#graphForm input').on('input', function() {
                                        var min = parseInt($('#minData').val());
                                        var max = parseInt($('#maxData').val());

                                        // Ensure min and max are within bounds
                                        if (min < 0) {
                                            min = 0;
                                        }
                                        if (max > 100) { // Assuming max range is 100%
                                            max = 100;
                                        }
                                        if (min > max) {
                                            var temp = min;
                                            min = max;
                                            max = temp;
                                        }

                                        // Update handle positions
                                        var sliderWidth = $('.slider-track').width();
                                        $('.slider-handle.min').css('left', min / 100 * sliderWidth);
                                        $('.slider-handle.max').css('left', max / 100 * sliderWidth);

                                        updateChart();
                                    });
                                });
                            </script>
                        </li>



                        <li class="list-group-item mt-1">
                            <span class="fs-5 fw-bold mx-3">Room Info</span>
                            <div class="mt-2 mb-2 row" id="roomInfo">
                                <div class="row">
                                    <div class="col-4">
                                        <label class="fw-bold" for="doubleCount">
                                            Double
                                        </label>
                                        <input class="form-control mt-1" type="number" min="1" step="1" pattern="\d+" value="" id="doubleCount">
                                    </div>
                                    <div class="col-4">
                                        <label class="fw-bold" for="tripleCount">
                                            Triple
                                        </label>
                                        <input class="form-control mt-1" type="number" min="1" step="1" pattern="\d+" value="" id="tripleCount">
                                    </div>
                                    <div class="col-4">
                                        <label class="fw-bold" for="suiteCount">
                                            Suite
                                        </label>
                                        <input class="form-control mt-1" type="number" min="1" step="1" pattern="\d+" value="" id="suiteCount">
                                    </div>
                                </div>
                            </div>
                        </li>

                        <li class="list-group-item mt-1 mb-1">
                            <p class="fs-5 fw-bold mx-3">Availability</p>
                            <div class="row" id="dateInfo">
                                <div class="row mb-2">
                                    <div class="col-6">
                                        <label class="fw-bold" for="checkInDate">
                                            Check In
                                        </label>
                                        <input class="form-control mt-1" type="date" value="" id="checkInDate">
                                    </div>
                                    <div class="col-6">
                                        <label class="fw-bold" for="checkOutDate">
                                            Check Out
                                        </label>
                                        <input class="form-control mt-1" type="date" value="" id="checkOutDate">
                                    </div>
                                </div>
                            </div>
                        </li>

                        <li class="list-group-item mt-1">
                            <div class="form-check">
                                <input class="form-check-input fs-5" type="checkbox" value="" id="hasOffer">
                                <label class="form-check-label fs-5 fw-bold mx-3" for="hasOffer">
                                    Has Offer
                                </label>
                            </div>
                            <div class="mt-2 mb-2 d-none row" id="offerCheck">
                                <div class="row">
                                    <div class="col-5">
                                        <label class="fw-bold" for="minOffer%">
                                            Min Offer(%)
                                        </label>
                                        <input class="form-control mt-1" type="number" min="1" step="1" pattern="\d+" value="" id="minOffer%">
                                    </div>
                                    <div class="col-2 p-3 fw-bold">to</div>
                                    <div class="col-5">
                                        <label class="fw-bold" for="maxOffer%">
                                            Max Offer(%)
                                        </label>
                                        <input class="form-control mt-1" type="number" min="1" step="1" pattern="\d+" value="" id="maxOffer%">
                                    </div>
                                </div>
                            </div>
                        </li>

                    </ul>
                </div>
                <div class="card col-8 d-grid mt-5" id="basicSearchResult">
                    <div class="container-fluid">
                        <div class="col-12 mt-4 mb-4 scrollbar" style="max-height: 1050px; overflow-y: auto; overflow-x: hidden;">
                            <div class="row gx-1"> <!-- Reduced gap between columns -->
                                <?php
                                $nr_rs = Database::search("SELECT * FROM `resort` 
                        INNER JOIN `resort_thumbnail` ON `resort`.`resort_id` = `resort_thumbnail`.`resort_id`
                        INNER JOIN `room_rates` ON `resort`.`resort_id` = `room_rates`.`resort_id`
                        INNER JOIN `resort_roomcount` ON `resort`.`resort_id` = `resort_roomcount`.`resort_id`
                        INNER JOIN `resort_address` ON `resort`.`resort_id` = `resort_address`.`resort_id`
                        INNER JOIN `city` ON `resort_address`.`city_id` = `city`.`city_id`
                        INNER JOIN `district` ON `city`.`district_id` = `district`.`id`
                        INNER JOIN `province` ON `district`.`province_id` = `province`.`id`
                        WHERE `status`='1' ORDER BY `datetime_added` DESC LIMIT 10");
                                $nr_num = $nr_rs->num_rows;

                                for ($z = 0; $z < $nr_num; $z++) {
                                    $nr_data = $nr_rs->fetch_assoc();

                                    $image_rs = Database::search("SELECT * FROM `resort_thumbnail` WHERE `resort_id`='" . $nr_data["resort_id"] . "'");
                                    $image_data = $image_rs->fetch_assoc();
                                ?>
                                    <div class="col-md-6 mb-3">
                                        <div class="card flex-row" style="width: 98%; height: 100%;"> <!-- Make card slightly smaller -->
                                            <div class="col-5" style="background: url('<?php echo $image_data["resort_thumbnail"]; ?>'); background-repeat: no-repeat; background-size: cover;"></div>
                                            <div class="col-7 d-flex flex-column" style="background-image: linear-gradient(#777777, #F9ECD8);">
                                                <div class="card-body text-center d-flex flex-column justify-content-between">
                                                    <div>
                                                        <h5 class="text-center text-light"><?php echo $nr_data['resort_name'] . ", " . $nr_data['city_name'] ?></h5>
                                                        <span class="card-text text-primary fw-bold">Starting From: &nbsp; $ <?php echo $nr_data["hb_double"]; ?> . 00</span>
                                                        <br />
                                                        <?php if ($nr_data["double"] > 0) { ?>
                                                            <span class="card-text text-success fw-bold">Available</span>
                                                            <br />
                                                            <span class="card-text text-light"><?php echo $nr_data["double"]; ?> Double Room(s) Available</span>
                                                            <br /><br />
                                                        <?php } else { ?>
                                                            <span class="card-text text-danger fw-bold">00 Rooms Available</span>
                                                            <br /><br />
                                                        <?php } ?>
                                                    </div>
                                                    <div>
                                                        <?php if ($nr_data["double"] > 0) { ?>
                                                            <div class="row mb-2">
                                                                <a href='<?php echo "singleresortView.php?resort_id=" . ($nr_data["resort_id"]) ?>' class="btn btn-success col-10 offset-1">Book Now</a>
                                                            </div>
                                                        <?php } else { ?>
                                                            <div class="row mb-2">
                                                                <button class="btn btn-success disabled col-10 offset-1">Buy Now</button>
                                                            </div>
                                                            <div class="row mb-2">
                                                                <button class="btn btn-danger disabled col-10 offset-1">Add to Cart</button>
                                                            </div>
                                                        <?php } ?>
                                                        <?php
                                                        $wishlist_rs = Database::search("SELECT * FROM `wishlist` WHERE `resort_id`='" . $nr_data["resort_id"] . "' AND `user_email`='" . $_SESSION["u"]["email"] . "'");
                                                        $wishlist_num = $wishlist_rs->num_rows;
                                                        if ($wishlist_num == 1) {
                                                        ?>
                                                            <div class="row">
                                                                <button class="btn btn-outline-light border border-danger col-10 offset-1 mt-2" onclick='addToWishlist(<?php echo $nr_data["resort_id"]; ?>); window.location.reload();'>
                                                                    <i class="bi bi-heart-fill text-danger fs-5" id='heart<?php echo $nr_data["resort_id"]; ?>'></i>
                                                                </button>
                                                            </div>
                                                        <?php } else { ?>
                                                            <div class="row">
                                                                <button class="btn btn-outline-light border border-secondary col-10 offset-1 mt-2" onclick='addToWishlist(<?php echo $nr_data["resort_id"]; ?>); window.location.reload();'>
                                                                    <i class="bi bi-heart-fill text-secondary fs-5" id='heart<?php echo $nr_data["resort_id"]; ?>'></i>
                                                                </button>
                                                            </div>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>


            </div>

            <?php include "../../footer.php"; ?>

            <script>
                document.getElementById('hasOffer').addEventListener('change', function() {
                    var offerCheck = document.getElementById("offerCheck");
                    if (this.checked) {
                        offerCheck.classList.add("d-block");
                        offerCheck.classList.remove("d-none");
                    } else {
                        offerCheck.classList.add("d-none");
                        offerCheck.classList.remove("d-block");
                    }
                });
            </script>

            <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
            <script src="../../js/script.js"></script>
</body>

</html>