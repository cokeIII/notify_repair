<?php
error_reporting( error_reporting() & ~E_NOTICE );
require_once "../connect.php";
$dep_id = $_REQUEST["dep_id"];
$level = $_REQUEST["level"];

$sql = "select art_id,level, concat(art_number,' ',art_name) as nameArt, art_x, art_y,art_number from articles 
where dep_id = '$dep_id' and level = '$level'";
$res = mysqli_query($conn,$sql);
$data = array();
$i=0;
while($row = mysqli_fetch_array($res)){
    $data[$i]["art_id"] = $row["art_id"];
    $data[$i]["level"] = $row["level"];
    $data[$i]["art_number"] = $row["art_number"];
    $data[$i]["nameArt"] = $row["nameArt"];
    $data[$i]["art_x"] = $row["art_x"];
    $data[$i]["art_y"] = $row["art_y"];
    $i++;
}
echo json_encode($data);