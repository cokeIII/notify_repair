<?php
require_once "../connect.php";
session_start();

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
            rep_status
        ) 
        values(
            '$equ_number',
            '$people_id',
            '$rep_description',
            'รายการส่งซ่อม'
        )
    ";
        $sqlEqu = "update equipment set equ_status = 'รายการส่งซ่อม'";

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
} else if(!empty($_REQUEST["cancel"])){
    $equ_number = $_REQUEST["equ_number"];
    $sql = "update equipment set equ_status = 'ปกติ' where equ_number = '$equ_number'";
    $res = mysqli_query($conn,$sql);
    $sqlRep = "update repair set rep_status = 'ยกเลิกรายการ' where equ_number = '$equ_number'";
    $resRep = mysqli_query($conn,$sqlRep);
    if ($res && $resRep) {
        header("location: ../repair/listRepair.php");
    } else {
        echo "fail";
    }
}
