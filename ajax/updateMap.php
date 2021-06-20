<?php
require_once "../connect.php";
if (!empty($_REQUEST["editMap"])) {
    $people_dep_id = $_REQUEST["people_dep_id"];
    $map_x = $_REQUEST["map_x"];
    $map_y = $_REQUEST["map_y"];
    $sql = "
            update map set map_x = '$map_x', map_y = '$map_y' where people_dep_id ='$people_dep_id'
        ";
    $res = mysqli_query($conn, $sql);
    if ($res) {
        echo "success";
    } else {
        echo "fail";
    }
}
