<?php

require "../../connection.php";

$t = $_POST["t"];

$query = "SELECT * FROM `user` WHERE `status`='1'";

if (!empty($t)) {
    $query .= " AND (`fname` LIKE '%" . $t . "%' OR `lname` LIKE '%" . $t . "%') ";
} else {
    $query .= " AND (`fname` LIKE '%" . $t . "%' OR `lname` LIKE '%" . $t . "%') ";
}

?>

<div class="row">
    <div class="offset-lg-1 col-12 col-lg-10 text-center">
        <div class="row">

            <div>oh hi </div>
            
            <?php

            if ("0" != ($_POST["page"])) {
                $pageno = $_POST["page"];
            } else {
                $pageno = 1;
            }

            $user_rs = Database::search($query);
            $user_num = $user_rs->num_rows;

            $results_per_page = 4;
            $number_of_pages = ceil($user_num / $results_per_page);

            $page_results = ($pageno - 1) * $results_per_page;
            $selected_rs = Database::search($query . " LIMIT " . $results_per_page . " OFFSET " . $page_results .  "");

            while ($user_data = $selected_rs->fetch_assoc()) {

            ?>

                <div class="row mt-4 align-items-center">
                    <div class="card col-10 offset-1">
                        <div class="card-body">
                            <h4 class="card-title fw-bold"><?php echo $user_data["fname"] . " " . $user_data["lname"]; ?></h4>
                            <p class="card-text">Joined in <?php echo $user_data["joined_datetime"]; ?>

                                <br />

                                <?php
                                if ($user_data["status"] == 1) {
                                ?>
                            <div class="row mt-4">
                                <div class="col-12 d-none d-lg-block offset-lg-1 col-lg-10 bg-light py-2" onclick="viewMsgModal('<?php echo ($user_data['email']); ?>');">
                                    <a class="offset-1 fw-bold text-dark text-decoration-none"><i class="bi bi-chat-left-text"></i> &nbsp; <b>Message User</b></a>
                                </div>

                                <div class="row">
                                    <br />
                                </div>

                                <div class="row">
                                    <button class="col-4 offset-2 btn btn-outline-dark" style="width: 30%;" id="ub<?php echo $user_data['email']; ?>" class="btn btn-danger" onclick="blockUser('<?php echo $user_data['email']; ?>');">Block</button>
                                    <button class="col-4 offset-1 btn btn-outline-danger" style="width: 30%;" id="du<?php echo $user_data['email']; ?>" onclick="deleteUser('<?php echo $user_data['email']; ?>');">Delete</button>
                                </div>
                            </div>
                        <?php
                                } else {
                        ?>
                            <button id="ub<?php echo $user_data['email']; ?>" class="col-4 offset-2 btn btn-outline-success" onclick="blockUser('<?php echo $user_data['email']; ?>');">Unblock</button>
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
                                            ?> onclick="searchUser(<?php echo ($pageno - 1) ?>);" <?php
                                                                                                } ?> aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
                <?php

                for ($x = 1; $x <= $number_of_pages; $x++) {
                    if ($x == $pageno) {
                ?>
                        <li class="page-item active">
                            <a class="page-link" onclick="searchUser(<?php echo ($x) ?>);"><?php echo $x; ?></a>
                        </li>
                    <?php
                    } else {
                    ?>
                        <li class="page-item">
                            <a class="page-link" onclick="searchUser(<?php echo ($x) ?>);"><?php echo $x; ?></a>
                        </li>
                <?php
                    }
                }

                ?>

                <li class="page-item">
                    <a class="page-link" <?php if ($pageno >= $number_of_pages) {
                                                echo "#";
                                            } else {
                                            ?> onclick="userSearch(<?php echo ($pageno + 1) ?>);" <?php
                                                                                                } ?> aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
    <!-- nav -->
</div>
