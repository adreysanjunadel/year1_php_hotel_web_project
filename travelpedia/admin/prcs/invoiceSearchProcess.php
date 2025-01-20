<?php

require "../../connection.php";

$s = $_POST["s"];
$e = $_POST["e"];

echo "Start Date: " . $s . "<br>";
echo "End Date: " . $e . "<br>";

$query = "SELECT * FROM `booking`
INNER JOIN `user` ON `booking`.`user_email` = `user`.`email`
INNER JOIN `user_address` ON `user_address`.`user_email` = `user`.`email`
INNER JOIN `resort` ON `booking`.`resort_id` = `resort`.`resort_id`
INNER JOIN `resort_thumbnail` ON `resort`.`resort_id` = `resort_thumbnail`.`resort_id`
INNER JOIN `room_rates` ON `resort`.`resort_id` = `room_rates`.`resort_id`
INNER JOIN `resort_address` ON `resort`.`resort_id` = `resort_address`.`resort_id`
INNER JOIN `city` ON `resort_address`.`city_id` = `city`.`city_id`
INNER JOIN `district` ON `city`.`district_id` = `district`.`id`
INNER JOIN `province` ON `district`.`province_id` = `province`.`id`
WHERE `resort`.`status`='1' ";

if (!empty($s) && empty($e)) {
    $query .= " AND DATE(`date_booked`) = '" . $s . "' ";
} else if (empty($s) && !empty($e)) {
    $query .= " AND DATE(`date_booked`) = '" . $e . "' ";
} else if (!empty($s) && !empty($e)) {
    $query .= " AND DATE(`date_booked`) BETWEEN '" . $s . "' AND '" . $e . "' ";
}

?>

<div class="row">

    <?php

    if (isset($_GET["page"])) {
        $pageno = $_GET["page"];
    } else {
        $pageno = 1;
    }


    $invoice_rs = Database::search($query);
    $invoice_num = $invoice_rs->num_rows;

    $results_per_page = 6;
    $number_of_pages = ceil($invoice_num / $results_per_page);

    $page_results = ($pageno - 1) * $results_per_page;
    $selected_rs =  Database::search($query . " LIMIT " . $results_per_page . " OFFSET " . $page_results . "");

    $selected_num = $selected_rs->num_rows;

    for ($i = 0; $i < $selected_num; $i++) {
        $selected_data = $selected_rs->fetch_assoc();

        $room_rs = Database::search("SELECT * FROM `room_rates`
                                INNER JOIN `resort` ON `room_rates`.`resort_id` = `resort`.`resort_id`
                                WHERE `resort`.`resort_id` = '" . $selected_data["resort_id"] . "' ");
        $room_data = $room_rs->fetch_assoc();
    ?>


        <div class="card col-10 offset-1 mt-2 mb-2">
            <div class="d-flex">
                <div class="card-body col-3 m-4 row">
                    <img src="<?php echo $selected_data["resort_thumbnail"]; ?>" class="card-img-top img-fluid" placeholder="<?php echo $selected_data["resort_name"]; ?>" style="height: 180px;background-size:contain" />
                </div>
                <div class="card-body col-lg-6 col-12 row">
                    <div class="fw-bold d-flex">
                        <h4 class="offset-1 col-4 row fw-bold p-2">
                            <?php echo $selected_data["resort_name"]; ?> &nbsp; &nbsp;&nbsp; &nbsp;
                        </h4>
                        <h5 class="col-1 row fw-bold p-2">
                            <h4>Details: &nbsp;<?php echo $selected_data["description"]; ?> </h4>
                        </h5>
                    </div>
                    <span class="fw-bold">Resort Address: &nbsp;&nbsp;<?php echo $selected_data["no"]  . " ,&nbsp; " . $selected_data["street1"] . " ,&nbsp; " . $selected_data["street2"] . " ,&nbsp " . $selected_data["city_name"] . " ,&nbsp; " . $selected_data["district_name"] . " ,&nbsp; " . $selected_data["province_name"]; ?> Province</span>
                    <span class="fw-bold">Contact No. : <?php echo $selected_data["resort_mobile"]; ?> (Contact For Further Queries / Booking Cancellation Inquiries) </span>
                    <span class="fw-bold">Date of Invoice : <h4><?php echo $selected_data["date_booked"]; ?> &nbsp; &nbsp; &nbsp; <button class="btn btn-outline-success col-6 offset-1 fw-bold" onclick="viewInvoice('<?php echo $selected_data['booking_id']; ?>');">Check Invoice</button></h4></span>
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