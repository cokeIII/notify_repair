<?php
error_reporting(error_reporting() & ~E_NOTICE);
require_once "../connect.php";
$equ_number = $_REQUEST["equ_number"];
$sql = "select * from equipment where equ_number = '$equ_number'";
$res = mysqli_query($conn, $sql);
$data = array();
$i = 0;
while ($row = mysqli_fetch_array($res)) {
    $data[$i]["equ_number"] = $row["equ_number"];
    $data[$i]["equ_name"] = $row["equ_name"];
    $data[$i]["equ_status"] = $row["equ_status"];
    $data[$i]["equ_description"] = $row["equ_description"];
    $data[$i]["equ_x"] = $row["equ_x"];
    $data[$i]["equ_y"] = $row["equ_y"];
    $i++;
}
echo json_encode($data);
