<?php
error_reporting(error_reporting() & ~E_NOTICE);
require_once "../connect.php";
$art_number = $_REQUEST["art_number"];
$sql = "select * from equipment where art_number = '$art_number'";
$res = mysqli_query($conn, $sql);
$data = array();
$i = 0;
while ($row = mysqli_fetch_array($res)) {
    $data[$i]["equ_number"] = $row["equ_number"];
    $data[$i]["equ_name"] = $row["equ_name"];
    $data[$i]["equ_description"] = $row["equ_description"];
    $data[$i]["equ_x"] = $row["equ_x"];
    $data[$i]["equ_y"] = $row["equ_y"];
    $i++;
}
echo json_encode($data);
