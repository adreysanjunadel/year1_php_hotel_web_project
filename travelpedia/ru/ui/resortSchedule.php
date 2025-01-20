<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Resort Schedule | Travelpedia</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../../style.css" />

    <link rel="icon" href="../../resources/travelpedia.jpg" />
</head>

<body class="bg vw-100 scrollbar" style="overflow-x: hidden;">
    <div class="container-fluid">
        <div class="row">

            <?php
            include "ruHeader.php";
            ?>

            <div class="col-12 p-4">
                <br />
                <h2 class="text-align-start fw-bold" style="margin-left: 5%;">Resort Schedule</h2>
                <br />
                <hr />
            </div>

            <?php

            if (isset($_SESSION["ru"]) && isset($_GET["resort_id"])) {
                $rumail = $_SESSION["ru"]["email"];
                $rid = $_GET["resort_id"];

                // to get bookings for a specific month
                function getBookingsForMonth($conn, $month)
                {
                    global $rumail;
                    $sql = "SELECT * FROM `booking`
                            INNER JOIN `resort` ON `booking`.`resort_id` = `resort`.`resort_id`
                            INNER JOIN `resort_user` ON `resort`.`resort_user_email` = `resort_user`.`email`
                            INNER JOIN `resort_address` ON `resort`.`resort_id` = `resort_address`.`resort_id`
                            INNER JOIN `resort_thumbnail` ON `resort`.`resort_id` = `resort_thumbnail`.`resort_id`
                            WHERE (`resort`.`resort_user_email` = '$rumail'
                            AND (MONTH(`booking`.`check_in`) = $month OR MONTH(`booking`.`check_out`) = $month OR (MONTH(`booking`.`check_in`) < $month AND MONTH(`booking`.`check_out`) > $month))";
                    $result = $conn->query($sql);
                    $bookings = [];

                    while ($row = $result->fetch_assoc()) {
                        $checkInDay = date("j", strtotime($row['check_in']));
                        $checkOutDay = date("j", strtotime($row['check_out']));

                        for ($day = $checkInDay; $day <= $checkOutDay; $day++) {
                            $bookings[$day][] = [
                                'check_in' => $row['check_in'],
                                'check_out' => $row['check_out'],
                                'description' => $row['description'],
                                'total' => $row['total'],
                                'resort_name' => $row['resort_name'],
                                'resort_thumbnail' => $row['resort_thumbnail'],
                            ];
                        }
                    }

                    return $bookings;
                }

                // Month names array
                $monthNames = [
                    1 => "January", 2 => "February", 3 => "March", 4 => "April",
                    5 => "May", 6 => "June", 7 => "July", 8 => "August",
                    9 => "September", 10 => "October", 11 => "November", 12 => "December"
                ];

                // Display bookings for each month (January, February, March)
                $monthsPerRow = 4;
                $monthsInYear = 12;
                $rows = ceil($monthsInYear / $monthsPerRow);
                for ($row = 1; $row <= $rows; $row++) {
                    echo '<div class="cal-container">';
                    echo '<div class="cal-row">';

                    for ($monthIndex = 0; $monthIndex < $monthsPerRow; $monthIndex++) {
                        $currentMonth = ($row - 1) * $monthsPerRow + 1 + $monthIndex;
                        if ($currentMonth <= 12) {
                            $monthName = $monthNames[$currentMonth];
                            $bookingsByDay = getBookingsForMonth(Database::$connection, $currentMonth);

                            echo '<div class="cal-month">';
                            echo '<div class="cal">';
                            echo '<div class="cal-month-name">' . $monthName . '</div>';

                            for ($day = 1; $day <= cal_days_in_month(CAL_GREGORIAN, $currentMonth, 2023); $day++) {
                                $bookedDetails = isset($bookingsByDay[$day]) ? $bookingsByDay[$day] : null;
                                echo '<div class="cal-day' . ($bookedDetails ? ' is-booked' : '') . '" data-details="' . htmlspecialchars(json_encode($bookedDetails), ENT_QUOTES, 'UTF-8') . '">';
                                echo $day;
                                echo '</div>';
                            }

                            echo '</div>';
                            echo '</div>';
                        }
                    }

                    echo '</div>';
                    echo '</div>';
                }
            } else {
                echo '<div class="col-12 vh-100">
                                    <div class="row">

                                        <div class="col-12 text-center p-4">
                                            <h1 class="form-label fw-bold text-center" style="margin-bottom: 5%;">Please Log In! 🙏🏼</h1>
                                        </div>
                                        <div class="col-12 adminEmpty"></div>
                                    </div>
                                </div>';
            }
            ?>

            <?php include "../../footer.php"; ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
    <script src="../../js/script.js"></script>
</body>

</html>