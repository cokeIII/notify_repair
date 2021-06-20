<?php
require_once "../connect.php";

$equ_number = $_REQUEST["equ_number"];
$equ_x = $_REQUEST["equ_x"];
$equ_y = $_REQUEST["equ_y"];
$sql = "
    update equipment set equ_x = '$equ_x', equ_y = '$equ_y' where equ_number ='$equ_number'
";
$res = mysqli_query($conn, $sql);
if ($res) {
    echo "success";
} else {
    echo $sql;
}
