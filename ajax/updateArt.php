<?php
// error_reporting(error_reporting() & ~E_NOTICE);
require_once "../connect.php";

$art_x = $_REQUEST["art_x"];
$art_y = $_REQUEST["art_y"];
$level = $_REQUEST["level"];
$art_id = $_REQUEST["art_id"];
$sql = "
    update articles set
    art_x = '$art_x',
    art_y = '$art_y',
    level = '$level'
    where art_id = '$art_id'
";
$res = mysqli_query($conn, $sql);
if ($res) {
    echo "success";
} else {
    echo "fail";
}
