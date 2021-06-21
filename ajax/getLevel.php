<?php
error_reporting(error_reporting() & ~E_NOTICE);
require_once "../connect.php";
$dep_id = $_REQUEST["dep_id"];
$sql = "select level from map where people_dep_id  = '$dep_id'";
$res = mysqli_query($conn, $sql);
$data = array();
$i = 0;
while ($row = mysqli_fetch_array($res)) {
    $data[$i]["level"] = $row["level"];
    $i++;
}
echo json_encode($data);
