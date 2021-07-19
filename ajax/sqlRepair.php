<?php
require_once "../connect.php";
session_start();
date_default_timezone_set("Asia/Bangkok");
// require('../vendor/autoload.php');
$dates = date("Y-m-d H:i:sa");
// require '../vendor/autoload.php';

// $options = array(
//     'cluster' => 'ap2',
//     // 'useTLS' => true,
//     'encrypted' => false
// );
// $pusher = new Pusher\Pusher(
//     '05ee423672484752406d',
//     '890135aa8648a8a9ba37',
//     '1237719',
//     $options
// );

// $data['message'] = 'hello world';
// $pusher->trigger('my-channel', 'my-event', $data);
if (!empty($_REQUEST["insert"])) {
    $equ_number = $_REQUEST["equ_number"];
    $sqlCheck = "select equ_status from equipment where equ_number = '$equ_number'";
    $resCheck = mysqli_query($conn, $sqlCheck);
    $rowCheck = mysqli_fetch_array($resCheck);

    $people_id = $_SESSION["people_id"];
    $rep_description = $_REQUEST["rep_description"];
    if ($rowCheck["equ_status"] == "ปกติ" || $rowCheck["equ_status"] == "ใช้งานไม่ได้") {
        $sql = "insert into repair 
        (
            equ_number,
            people_id,
            rep_description,
            rep_status,
            rep_time
        ) 
        values(
            '$equ_number',
            '$people_id',
            '$rep_description',
            'รายการส่งซ่อม',
            '$dates'
        )
    ";
        $sqlEqu = "update equipment set equ_status = 'รายการส่งซ่อม' where equ_number = '$equ_number'";

        $resEqu = mysqli_query($conn, $sqlEqu);
        $res = mysqli_query($conn, $sql);
        if ($res) {
            echo "success";
        } else {
            echo "fail";
        }
    } else {
        echo "repeat row";
    }
} else if (!empty($_REQUEST["cancel"])) {
    $equ_number = $_REQUEST["equ_number"];
    $rep_id = $_REQUEST["rep_id"];
    $sql = "update equipment set equ_status = 'ปกติ' where equ_number = '$equ_number'";
    $res = mysqli_query($conn, $sql);
    $sqlRep = "update repair set rep_status = 'ยกเลิกรายการ', user_read = '', rep_time = '$dates'  where rep_id = '$rep_id'";
    $resRep = mysqli_query($conn, $sqlRep);
    if ($res && $resRep) {
        header("location: ../repair/listRepair.php");
    } else {
        echo "fail";
    }
} else if (!empty($_REQUEST["accept"])) {
    $equ_number = $_REQUEST["equ_number"];
    $rep_id = $_REQUEST["rep_id"];
    $sql = "update equipment set equ_status = 'กำลังดำเนินการซ่อม' where equ_number = '$equ_number'";
    $res = mysqli_query($conn, $sql);
    $sqlRep = "update repair set rep_status = 'กำลังดำเนินการซ่อม', user_read = '', rep_time = '$dates' where rep_id = '$rep_id'";
    $resRep = mysqli_query($conn, $sqlRep);
    if ($res && $resRep) {
        header("location: ../repair/listRepair.php");
    } else {
        echo "fail";
    }
} else if (!empty($_REQUEST["delete"])) {
    $rep_id = $_REQUEST["rep_id"];
    $sql = "delete from repair where rep_id = '$rep_id'";
    $res = mysqli_query($conn, $sql);
    $equ_number = $_REQUEST["equ_number"];
    $sql = "update equipment set equ_status = 'ปกติ' where equ_number = '$equ_number'";
    $res = mysqli_query($conn, $sql);
    if ($res) {
        header("location: ../repair/listRepair.php");
    } else {
        echo "fail";
    }
} else if (!empty($_REQUEST["success"])) {
    $equ_number = $_REQUEST["equ_number"];
    $rep_id = $_REQUEST["rep_id"];
    $sql = "update equipment set equ_status = 'ปกติ' where equ_number = '$equ_number'";
    $res = mysqli_query($conn, $sql);
    $sqlRep = "update repair set rep_status = 'สำเร็จ', user_read = '', rep_time = '$dates' where rep_id = '$rep_id'";
    $resRep = mysqli_query($conn, $sqlRep);
    if ($res && $resRep) {
        header("location: ../repair/listRepair.php");
    } else {
        echo "fail";
    }
}
