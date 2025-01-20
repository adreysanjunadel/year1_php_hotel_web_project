<?php

session_start();

include_once '../../connection.php';

    if (isset($_GET['start_date']) && isset($_GET['end_date'])) {
        $start_date = $_GET['start_date'];
        $end_date = $_GET['end_date'];

        // checks if customer has booking for given time period
        $umail = $_SESSION['u']['email'];
        $active_search = "SELECT COUNT(*) AS active_bookings
              FROM `booking` WHERE `user_email` = $umail AND (`check_in` <= '$end_date' AND `check_out` >= '$start_date')";

        $result = Database::search($active_search);

        if ($result) {
            $active_bookings = 0;
        
            // adds active booking if there is a result
            while ($row = $result->fetch_assoc()) {
                $active_bookings += $row['active_bookings'];
            }
        
            $selected_dates_overlapping = 0;
            $umail = $_SESSION['u']['email'];
            $current_search = "SELECT COUNT(*) AS `selected_dates_overlapping`
                  FROM `booking` WHERE `user_email` = $umail AND `check_in` <= '$end_date' AND `check_out` >= '$start_date'";
            $current_search_data = Database::search($current_search);
        
            // if selected date overlaps active booking
            if ($current_search_data) {
                $row_selected_dates = $current_search_data->fetch_assoc();
                $selected_dates_overlapping = $row_selected_dates['selected_dates_overlapping'];
            }
        
            if (($active_bookings + $selected_dates_overlapping) > 2) {
                echo "You cannot make more than two active bookings for the selected timeframe.";
            } else {
                // no double booking
            }
            
        } else {
            // bad response
            echo "Error checking for overlapping bookings";
        }  
}

?>
