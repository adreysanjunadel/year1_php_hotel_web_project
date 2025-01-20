<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Schedule | Travelpedia</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../../style.css" />
    <link rel="stylesheet" href="../../styles/calendar-heatmap.css"> <!-- Adjust the path accordingly -->
    <link rel="icon" href="../../resources/travelpedia.jpg" />
    <style>
        .card {
            background-color: #fff;
            border: 1px solid rgba(0, 0, 0, 0.125);
            border-radius: 0.25rem;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-bottom: 20px;
            position: relative;
        }

        .card-header {
            background-color: #814A3E;
            color: #fff;
            padding: 10px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            border-top-left-radius: 0.25rem;
            border-top-right-radius: 0.25rem;
        }

        .heatmap-container {
            position: relative;
        }

        .heatmap-year {
            position: absolute;
            top: 0;
            right: -50px;
            font-size: 14px;
            font-weight: bold;
            transform: rotate(-90deg);
            transform-origin: top left;
            color: #6a737d;
        }

        .heatmap-scale {
            display: flex;
            justify-content: space-between;
            font-size: 12px;
            color: #6a737d;
            margin-top: 10px;
        }

        .heatmap-day {
            position: relative;
            cursor: pointer;
        }

        .heatmap-day:hover::before {
            content: attr(data-count);
            position: absolute;
            top: -25px;
            left: 50%;
            transform: translateX(-50%);
            padding: 5px 10px;
            background-color: rgba(0, 0, 0, 0.75);
            color: #fff;
            font-size: 12px;
            border-radius: 5px;
            z-index: 1000;
            pointer-events: none;
        }

        .badge {
            font-size: 0.75rem;
            padding: 0.3rem 0.6rem;
            border-radius: 0.5rem;
        }
    </style>
</head>

<body class="bg vw-100 scrollbar" style="background-image: linear-gradient(#814A3E, #1F4A5E); overflow-x:hidden;">
    <div class="container-fluid">
        <div class="row">
            <?php include "header.php"; ?>
            <?php if (isset($_SESSION["u"])) :
                $umail = $_SESSION["u"]["email"];
                // Fetch booking data
                $book_rs = Database::search("SELECT DATE(`booking`.`check_in`) AS `date`, COUNT(*) AS `count` 
                                             FROM `booking` 
                                             INNER JOIN `resort` ON `booking`.`resort_id` = `resort`.`resort_id` 
                                             WHERE `resort`.`status` = '1' AND `booking`.`user_email` = '$umail' 
                                             GROUP BY `date`");
                $booking_data = [];
                while ($row = $book_rs->fetch_assoc()) {
                    $booking_data[] = ['date' => date('Y-m-d', strtotime($row['date'])), 'count' => (int)$row['count']]; // Ensure date is formatted correctly
                }
                $booking_data_json = json_encode($booking_data);
                $last_year_bookings = array_sum(array_column($booking_data, 'count'));
            ?>
                <div class="col-10 offset-1 card">
                    <div class="card-header">
                        Booking Activity
                        <span class="badge bg-light text-dark ms-2"><?php echo $last_year_bookings; ?> bookings last year</span>
                    </div>
                    <div class="row">
                        <div class="col-10">
                            <div class="heatmap-container">
                                <div id="booking-heatmap" class="heatmap-grid">
                                    <!-- Calendar heatmap will be generated here -->
                                </div>
                            </div>
                        </div>
                        <div class="col-2">
                            <?php for ($year = 2024; $year >= 2020; $year--) : ?>
                                <div class="heatmap-year"><?php echo $year; ?></div>
                            <?php endfor; ?>
                        </div>
                    </div>
                    <div class="heatmap-scale">
                        <span>Less</span>
                        <span>More</span>
                    </div>
                </div>
            <?php else : ?>
                <p>Please Log In</p>
            <?php endif; ?>
            <?php include "../../footer.php"; ?>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
    <script src="https://d3js.org/d3.v7.min.js"></script>
    <script src="../../js/moment.js"></script>
    <script src="../../js/calendar-heatmap.js"></script>
    <script>
        // Assuming you have fetched and encoded your booking data in PHP and placed it in a variable like $booking_data_json
        var bookingData = <?php echo $booking_data_json ?? '[]'; ?>; // Default to empty array if $booking_data_json is not set

        // Initialize calendar heatmap
        var heatmap = calendarHeatmap()
            .data(bookingData)
            .selector('#booking-heatmap')
            .tooltipEnabled(true)
            .colorRange(['#FFEFD5', '#331A00'])
            .onClick(function(data) {
                console.log('onClick', data);
            });

        heatmap();
    </script>
</body>

</html>
