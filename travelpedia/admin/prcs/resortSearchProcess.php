<?php

require "../../connection.php";

$t = $_POST["t"];

$query = "SELECT * FROM `resort`
INNER JOIN `resort_thumbnail` ON `resort`.`resort_id` = `resort_thumbnail`.`resort_id`
INNER JOIN `room_rates` ON `resort`.`resort_id` = `room_rates`.`resort_id`
INNER JOIN `resort_address` ON `resort`.`resort_id` = `resort_address`.`resort_id`
INNER JOIN `city` ON `resort_address`.`city_id` = `city`.`city_id`
INNER JOIN `district` ON `city`.`district_id` = `district`.`id`
INNER JOIN `province` ON `district`.`province_id` = `province`.`id`
WHERE `status`='1'";

if (!empty($t)) {
    $query .= " AND `resort_name` LIKE '%" . $t . "%' ";
} else {
    $query .= " AND `resort_name` LIKE '%" . $t . "%' ";
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

            $res_rs = Database::search($query);
            $res_num = $res_rs->num_rows;

            $results_per_page = 4;
            $number_of_pages = ceil($res_num / $results_per_page);
            
            $page_results = ($pageno - 1) * $results_per_page;
            $selected_rs = Database::search($query . " LIMIT " . $results_per_page . " OFFSET " . $page_results .  "");

            while ($res_data = $selected_rs->fetch_assoc()) {

            ?>

                <div class="row mt-4 align-items-center">
                    <div class="card col-10 offset-1">
                        <div class="card-body">
                            <h4 class="card-title fw-bold"><?php echo $res_data["resort_name"] . " " . $res_data["city_name"]; ?></h4>
                            <p class="card-text">Joined in <?php echo $res_data["datetime_added"]; ?>
                                <br />

                                <?php
                                if ($res_data["status"] == 1) {
                                ?>
                            <div class="row mt-4">
                                <button class="col-10 offset-1 btn btn-outline-dark" id="rb<?php echo $res_data['resort_id']; ?>" class="btn btn-danger" onclick="blockResort('<?php echo $selected_data['resort_id']; ?>');">Block Resort</button>
                            </div>
                        <?php
                                } else {
                        ?>
                            <button id="rb<?php echo $res_data['resort_id']; ?>" class="col-10 offset-1 btn btn-outline-success" onclick="blockResort('<?php echo $selected_data['resort_id']; ?>');">Unblock Resort</button>
                        <?php

                                }

                        ?>
                        </div>
                    </div>
                </div>
                <hr class="border-0" />

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
                                            ?> onclick="resortSearch(<?php echo ($pageno - 1) ?>);" <?php
                                                                                                    } ?> aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
                <?php

                for ($x = 1; $x <= $number_of_pages; $x++) {
                    if ($x == $pageno) {
                ?>
                        <li class="page-item active">
                            <a class="page-link" onclick="resortSearch(<?php echo ($x) ?>);"><?php echo $x; ?></a>
                        </li>
                    <?php
                    } else {
                    ?>
                        <li class="page-item">
                            <a class="page-link" onclick="resortSearch(<?php echo ($x) ?>);"><?php echo $x; ?></a>
                        </li>
                <?php
                    }
                }

                ?>

                <li class="page-item">
                    <a class="page-link" <?php if ($pageno >= $number_of_pages) {
                                                echo "#";
                                            } else {
                                            ?> onclick="resortSearch(<?php echo ($pageno + 1) ?>);" <?php
                                                                                                    } ?> aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
    <!-- nav -->
</div>