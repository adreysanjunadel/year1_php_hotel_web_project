<?php

require "../../connection.php";

$txt = $_POST["t"];
$province = $_POST["p"];
$district = $_POST["d"];
$city = $_POST["c"];
$price_from = $_POST["pf"];
$price_to = $_POST["to"];
$sort = $_POST["s"];

$query = "SELECT * FROM `resort` 
INNER JOIN `resort_roomcount` ON `resort`.`resort_id` = `resort_roomcount`.`resort_id`
INNER JOIN `resort_address` ON `resort_address`.`resort_id` = `resort`.`resort_id`
INNER JOIN `resort_thumbnail` ON `resort_thumbnail`.`resort_id` = `resort`.`resort_id`
INNER JOIN `room_rates` ON `room_rates`.`resort_id` = `resort`.`resort_id`
INNER JOIN `city` ON `resort_address`.`city_id` = `city`.`city_id`
INNER JOIN `district` ON `city`.`district_id` = `district`.`id`
INNER JOIN `province` ON `district`.`province_id` = `province`.`id`";

$status = 0;

if ($sort == 0) {

    if (!empty($txt)) {
        $query .= " WHERE `resort_name` LIKE '%" . $txt . "%'";
        $status = 1;
    }

    if ($status == 0 && $province != 0) {
        $query .= " WHERE `district`.`province_id`='" . $province . "'";
        $status = 1;
    } else if ($status != 0 && $province != 0) {
        $query .= " AND `district`.`province_id`='" . $province . "'";
    }

    if ($status == 0 && $district != 0) {
        $query .= " WHERE `city`.`district_id`='" . $district . "'";
        $status = 1;
    } else if ($status != 0 && $district != 0) {
        $query .= " AND `city`.`district_id`='" . $district . "'";
    }

    if ($status == 0 && $city != 0) {
        $query .= " WHERE `resort_address`.`city_id`='" . $city . "'";
        $status = 1;
    } else if ($status != 0 && $city != 0) {
        $query .= " AND `resort_address`.`city_id`='" . $city . "'";
    }



    if (!empty($price_from) && empty($price_to)) {
        if ($status == 0) {
            $query .= " WHERE `hb_double` >= '" . $price_from . "'";
            $status = 1;
        } else if ($status != 0) {
            $query .= " AND `hb_double` >= '" . $price_from . "'";
        }
    } else if (empty($price_from) && !empty($price_to)) {
        if ($status == 0) {
            $query .= " WHERE `hb_double` <= '" . $price_to . "'";
            $status = 1;
        } else if ($status != 0) {
            $query .= " AND `price` <= '" . $price_to . "'";
        }
    } else if (!empty($price_from) && !empty($price_to)) {
        if ($status == 0) {
            $query .= " WHERE `hb_double` BETWEEN '" . $price_from . "' AND '" . $price_to . "'";
            $status = 1;
        } else if ($status != 0) {
            $query .= " AND `hb_double` BETWEEN '" . $price_from . "' AND '" . $price_to . "'";
        }
    }
} else if ($sort == 1) {
    if (!empty($txt)) {
        $query .= " WHERE `resort_name` LIKE '%" . $txt . "%' ORDER BY `resort_roomrates`.`hb_double` DESC";
        $status = 1;
    }
} else if ($sort == 2) {
    if (!empty($txt)) {
        $query .= " WHERE `resort_name` LIKE '%" . $txt . "%' ORDER BY `resort_roomrates`.`hb_double` ASC";
        $status = 1;
    }
} else if ($sort == 3) {
    if (!empty($txt)) {
        $query .= " WHERE `resort_name` LIKE '%" . $txt . "%' ORDER BY `resort_roomcount`.`double` DESC";
        $status = 1;
    }
} else if ($sort == 4) {
    if (!empty($txt)) {
        $query .= " WHERE `resort_name` LIKE '%" . $txt . "%' ORDER BY `resort_roomcount`.`double` ASC";
        $status = 1;
    }
} else if ($sort == 5) {
    if (!empty($txt)) {
        $query .= " WHERE `resort_name` LIKE '%" . $txt . "%' ORDER BY `resort_roomcount`.`triple` DESC";
        $status = 1;
    }
} else if ($sort == 6) {
    if (!empty($txt)) {
        $query .= " WHERE `resort_name` LIKE '%" . $txt . "%' ORDER BY `resort_roomcount`.`triple` ASC";
        $status = 1;
    }
} else if ($sort == 7) {
    if (!empty($txt)) {
        $query .= " WHERE `resort_name` LIKE '%" . $txt . "%' ORDER BY `resort_roomcount`.`suite` DESC";
        $status = 1;
    }
} else if ($sort == 8) {
    if (!empty($txt)) {
        $query .= " WHERE `resort_name` LIKE '%" . $txt . "%' ORDER BY `resort_roomcount`.`suite` ASC";
        $status = 1;
    }
}

if ($_POST["page"] != "0") {

    $pageno = $_POST["page"];
} else {

    $pageno = 1;
}

$resort_rs = Database::search($query);
$resort_num = $resort_rs->num_rows;

$results_per_page = 6;
$number_of_pages = ceil($resort_num / $results_per_page);

$viewed_results_count = ((int)$pageno - 1) * $results_per_page;

$query .= " LIMIT " . $results_per_page . " OFFSET " . $viewed_results_count . "";
$results_rs = Database::search($query);
$results_num = $results_rs->num_rows;

while ($results_data = $results_rs->fetch_assoc()) {
?>

    <div class="row">
        <div class="offset-lg-1 col-12 col-lg-10 text-center">
            <div class="row">

                <!-- add variables -->
                <div class="offset-md-1 col-md-10 mb-3">
                    <div class="card flex-row" style="width: 98%; height: 100%;"> <!-- Make card slightly smaller -->
                        <div class="col-5" style="background: url('<?php echo $results_data["resort_thumbnail"]; ?>'); background-repeat: no-repeat; background-size: cover;"></div>
                        <div class="col-7 d-flex flex-column" style="background-image: linear-gradient(#777777, #F9ECD8);">
                            <div class="card-body text-center d-flex flex-column justify-content-between">
                                <div>
                                    <h5 class="text-center text-light"><?php echo $results_data['resort_name'] . ", " . $results_data['city_name'] ?></h5>
                                    <span class="card-text text-primary fw-bold">Starting From: &nbsp; $ <?php echo $results_data["hb_double"]; ?> . 00</span>
                                    <br />
                                    <?php if ($results_data["double"] > 0) { ?>
                                        <span class="card-text text-success fw-bold">Available</span>
                                        <br />
                                        <span class="card-text text-light"><?php echo $results_data["double"]; ?> Double Room(s) Available</span>
                                        <br /><br />
                                    <?php } else { ?>
                                        <span class="card-text text-danger fw-bold">00 Rooms Available</span>
                                        <br /><br />
                                    <?php } ?>
                                </div>
                                <div>
                                    <?php if ($results_data["double"] > 0) { ?>
                                        <div class="row mb-2">
                                            <a href='<?php echo "singleresortView.php?resort_id=" . ($results_data["resort_id"]) ?>' class="btn btn-success col-10 offset-1">Book Now</a>
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
                                    $wishlist_rs = Database::search("SELECT * FROM `wishlist` WHERE `resort_id`='" . $results_data["resort_id"] . "' AND `user_email`='" . $_SESSION["u"]["email"] . "'");
                                    $wishlist_num = $wishlist_rs->num_rows;
                                    if ($wishlist_num == 1) {
                                    ?>
                                        <div class="row">
                                            <button class="btn btn-outline-light border border-danger col-10 offset-1 mt-2" onclick='addToWishlist(<?php echo $results_data["resort_id"]; ?>); window.location.reload();'>
                                                <i class="bi bi-heart-fill text-danger fs-5" id='heart<?php echo $results_data["resort_id"]; ?>'></i>
                                            </button>
                                        </div>
                                    <?php } else { ?>
                                        <div class="row">
                                            <button class="btn btn-outline-light border border-secondary col-10 offset-1 mt-2" onclick='addToWishlist(<?php echo $results_data["resort_id"]; ?>); window.location.reload();'>
                                                <i class="bi bi-heart-fill text-secondary fs-5" id='heart<?php echo $results_data["resort_id"]; ?>'></i>
                                            </button>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

<?php
}

?>



<!-- nav -->
<div class="offset-2 offset-lg-3 col-8 col-lg-6 text-center mb-3">
    <nav aria-label="Page navigation example">
        <ul class="pagination pagination-lg justify-content-center">
            <li class="page-item">
                <a class="page-link" <?php if ($pageno <= 1) {
                                            echo "#";
                                        } else {
                                        ?> onclick="advancedSearch(<?php echo ($pageno - 1) ?>);" <?php
                                                                                                } ?> aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                </a>
            </li>
            <?php

            for ($x = 1; $x <= $number_of_pages; $x++) {
                if ($x == $pageno) {
            ?>
                    <li class="page-item active">
                        <a class="page-link" onclick="advancedSearch(<?php echo ($x) ?>);"><?php echo $x; ?></a>
                    </li>
                <?php
                } else {
                ?>
                    <li class="page-item">
                        <a class="page-link" onclick="advancedSearch(<?php echo ($x) ?>);"><?php echo $x; ?></a>
                    </li>
            <?php
                }
            }

            ?>

            <li class="page-item">
                <a class="page-link" <?php if ($pageno >= $number_of_pages) {
                                            echo "#";
                                        } else {
                                        ?> onclick="advancedSearch(<?php echo ($pageno + 1) ?>);" <?php
                                                                                                } ?> aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                </a>
            </li>
        </ul>
    </nav>
</div>
<!-- nav -->