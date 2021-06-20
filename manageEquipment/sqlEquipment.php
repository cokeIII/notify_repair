<?php
require_once "../connect.php";
if (!empty($_REQUEST["insert"])) {
    $equ_number = $_REQUEST["equ_number"];
    $equ_name = $_REQUEST["equ_name"];
    $equ_description = $_REQUEST["equ_description"];
    $equ_price = $_REQUEST["equ_price"];
    $art_number = $_REQUEST["art_number"];
    $equ_status = $_REQUEST["equ_status"];

    $sql="insert into equipment
    (
        equ_number,
        equ_name,
        equ_description,
        equ_price,
        art_number,
        equ_status
    )
    values(
        '$equ_number',
        '$equ_name',
        '$equ_description',
        '$equ_price',
        '$art_number',
        '$equ_status'      
    )
    ";

    $res = mysqli_query($conn,$sql);
    if($res){
        header("location: equipment.php");
    } else {
        echo $sql;
    }
} else if(!empty($_REQUEST["update"])){

    $equ_number = $_REQUEST["equ_number"];
    $equ_name = $_REQUEST["equ_name"];
    $equ_description = $_REQUEST["equ_description"];
    $equ_price = $_REQUEST["equ_price"];
    $art_number = $_REQUEST["art_number"];
    $equ_status = $_REQUEST["equ_status"];

    $sql = "
        update equipment set
        equ_name = '$equ_name',
        equ_description = '$equ_description',
        equ_price = '$equ_price',
        art_number = '$art_number',
        equ_status = '$equ_status'
        where equ_number = '$equ_number'
    ";

    $res = mysqli_query($conn,$sql);
    if($res){
        header("location: equipment.php");
    } else {
        echo $sql;
    }
} else if(!empty($_REQUEST["delEqu"])){
    $equ_number = $_REQUEST["equ_number"];
    $sql = "delete from equipment where equ_number = '$equ_number'";
    $res = mysqli_query($conn,$sql);
    if($res){
        header("location: equipment.php");
    } else {
        echo $sql;
    }
}