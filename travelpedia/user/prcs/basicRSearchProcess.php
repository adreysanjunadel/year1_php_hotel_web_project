<?php

require "../../connection.php";

$t = $_POST["t"];
$s = $_POST["s"];

$query = "SELECT * FROM `resort` 
INNER JOIN `resort_thumbnail` ON `resort`.`resort_id` = `resort_thumbnail`.`resort_id`
INNER JOIN `room_rates` ON `resort`.`resort_id` = `room_rates`.`resort_id`
INNER JOIN `resort_address` ON `resort`.`resort_id` = `resort_address`.`resort_id`
INNER JOIN `city` ON `resort_address`.`city_id` = `city`.`city_id`
INNER JOIN `district` ON `city`.`district_id` = `district`.`id`
INNER JOIN `province` ON `district`.`province_id` = `province`.`id` WHERE `status`='1'";

if (!empty($t) && $s == 0) {
    $query .= " AND `resort_name` LIKE '%" . $t . "%'";
} else if (empty($t) && $s != 0) {
    $query .= " AND `province`.`id`= '" . $s . "' ";
} else if (!empty($t) && $s != 0) {
    $query .= " AND (`resort_name` LIKE '%" . $t . "%' AND `province`.`id`='" . $s . "')";
}

?>

<div class="row">
    <div class="offset-lg-1 col-12 col-lg-10 text-center">
        <div class="row">

            <?php

            if ("0" != ($_POST["page"])) {
                $pageno = $_POST["page"];
            } else {
                $pageno = 1;
            }

            $resort_rs = Database::search($query);
            $resort_num = $resort_rs->num_rows;
            $resort_data = $resort_rs->fetch_assoc();

            $results_per_page = 6;
            $number_of_pages = ceil($resort_num / $results_per_page);

            $page_results = ($pageno - 1) * $results_per_page;
            $selected_rs = Database::search($query . " LIMIT " . $results_per_page . " OFFSET " . $page_results .  "");

            $selected_num = $selected_rs->num_rows;

            for ($s = 0; $s < $selected_num; $s++) {
                $selected_data = $selected_rs->fetch_assoc();

                $room_rs = Database::search("SELECT * FROM `room_rates`
                INNER JOIN `resort` ON `room_rates`.`resort_id` = `resort`.`resort_id` 
                WHERE `resort`.`resort_id` = '" . $selected_data["resort_id"] . "' ");
                $room_data = $room_rs->fetch_assoc();

            ?>

                <div class="card col-12 offset-lg-1 col-lg-10 mt-2 mb-2 p-2">
                    <div class="d-flex">
                        <div class="card-body col-3 m-4 row">
                            <img src="<?php echo $selected_data["resort_thumbnail"]; ?>" class="card-img-top img-fluid" placeholder="<?php echo $selected_data["resort_name"]; ?>" style="height: 180px;background-size:contain" />
                        </div>
                        <div class="card-body col-lg-6 col-12 row">
                            <h4 class="fw-bold">
                                <?php echo $selected_data["resort_name"]; ?> &nbsp; &nbsp; <span class="fs-6">Starting From: <?php echo $room_data["hb_double"]; ?>  $</span>
                            </h4>
                            <span class="fw-bold">Resort Address: &nbsp;&nbsp;<?php echo $selected_data["no"]  . " ,&nbsp; " . $selected_data["street1"] . " ,&nbsp; " . $selected_data["street2"] . " ,&nbsp " . $selected_data["city_name"] . " ,&nbsp; " . $selected_data["district_name"] . " ,&nbsp; " . $selected_data["province_name"]; ?> Province</span>
                            <span class="fw-bold">Contact : <b> <?php echo $selected_data["resort_mobile"]; ?> </b> </span>
                            <span class="fw-bold">Availability : </span>
                            <span class="fw-bold">Rating : </span>
                            <span class="fw-bold">Partner Resort Since : <b> <?php echo $selected_data["datetime_added"]; ?> </b> </span>
                        </div>
                        <div class="card-body col-lg-3 col-12 m-4 row d-flex">
                            <a class="text-decoration-none col-lg-10 offset-lg-1 m-3 p-4 btn btn-outline-dark fw-bold" href='<?php echo "singleResortView.php?resort_id=" . ($selected_data["resort_id"]) ?>'><span class="fs-5">Make a Booking</span></a>
                            <a class="col-lg-10 offset-lg-1 m-3 p-4 btn btn-outline-danger fw-bold" id="wishbtn" onclick="addToWishlist(<?php echo $selected_data['resort_id']; ?>);" id="wish">
                                <span class="fs-5" id='wish<?php echo $selected_data["resort_id"]; ?>'>Add To Wishlist</span>
                            </a>
                        </div>
                    </div>
                </div>

            <?php

            }
            ?>

        </div>
    </div>

    <!-- nav -->
    <div class="offset-2 offset-lg-3 col-8 col-lg-6 text-center mb-3">
        <nav aria-label="Page navigation example">
            <ul class="pagination pagination-lg justify-content-center">
                <li class="page-item">
                    <a class="page-link" <?php if ($pageno <= 1) {
                                                echo "#";
                                            } else {
                                            ?> onclick="basicSearch(<?php echo ($pageno - 1) ?>);" <?php
                                                                                                } ?> aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
                <?php

                for ($x = 1; $x <= $number_of_pages; $x++) {
                    if ($x == $pageno) {
                ?>
                        <li class="page-item active">
                            <a class="page-link" onclick="basicSearch(<?php echo ($x) ?>);"><?php echo $x; ?></a>
                        </li>
                    <?php
                    } else {
                    ?>
                        <li class="page-item">
                            <a class="page-link" onclick="basicSearch(<?php echo ($x) ?>);"><?php echo $x; ?></a>
                        </li>
                <?php
                    }
                }

                ?>

                <li class="page-item">
                    <a class="page-link" <?php if ($pageno >= $number_of_pages) {
                                                echo "#";
                                            } else {
                                            ?> onclick="basicSearch(<?php echo ($pageno + 1) ?>);" <?php
                                                                                                } ?> aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
    <!-- nav -->
</div>