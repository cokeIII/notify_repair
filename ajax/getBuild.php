<?php
require_once "../connect.php";
$dep_id = $_REQUEST["dep_id"];
$sql = "select art_id, concat(art_number,' ',art_name) as nameArt from articles where dep_id = '$dep_id'";
$res = mysqli_query($conn,$sql);
$data = array();
$i=0;
while($row = mysqli_fetch_array($res)){
    $data[$i]["art_id"] = $row["art_id"];
    $data[$i]["nameArt"] = $row["nameArt"];
    $i++;
}
echo json_encode($data);