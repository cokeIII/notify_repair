<?php
error_reporting(error_reporting() & ~E_NOTICE);
require_once "../connect.php";
if (!empty($_REQUEST["getMap"])) {
    $sql = "select m.*,pd.people_dep_name from map m, people_dep pd where m.people_dep_id = pd.people_dep_id";
    $res = mysqli_query($conn, $sql);
    $data = array();
    $i = 0;
    while ($row = mysqli_fetch_array($res)) {
        $data[$i]["people_dep_id"] = $row["people_dep_id"];
        $data[$i]["people_dep_name"] = $row["people_dep_name"];
        $data[$i]["map_x"] = $row["map_x"];
        $data[$i]["map_y"] = $row["map_y"];
        $i++;
    }
    echo json_encode($data);
} else if (!empty($_REQUEST["getMapLook"])) {
    $people_dep_id = $_REQUEST["people_dep_id"];
    $sql = "select m.*,pd.people_dep_name from map m, people_dep pd where m.people_dep_id = pd.people_dep_id and m.people_dep_id = '$people_dep_id'";
    $res = mysqli_query($conn, $sql);
    $data = array();
    $i = 0;
    while ($row = mysqli_fetch_array($res)) {
        $data[$i]["people_dep_id"] = $row["people_dep_id"];
        $data[$i]["people_dep_name"] = $row["people_dep_name"];
        $data[$i]["map_x"] = $row["map_x"];
        $data[$i]["map_y"] = $row["map_y"];
        $i++;
    }
    echo json_encode($data);
} else if (!empty($_REQUEST["getMapLookArt"])) {
    $art_id = $_REQUEST["art_id"];
    $sql = "select art_id,level, concat(art_number,' ',art_name) as nameArt, art_x, art_y,art_number from articles 
    where art_id = '$art_id'";
    $res = mysqli_query($conn, $sql);
    $data = array();
    $i = 0;
    while ($row = mysqli_fetch_array($res)) {
        $data[$i]["art_id"] = $row["art_id"];
        $data[$i]["level"] = $row["level"];
        $data[$i]["art_number"] = $row["art_number"];
        $data[$i]["nameArt"] = $row["nameArt"];
        $data[$i]["art_x"] = $row["art_x"];
        $data[$i]["art_y"] = $row["art_y"];
        $i++;
    }
    echo json_encode($data);
} else if (!empty($_REQUEST["getMapLookEqu"])) {
    $art_number = $_REQUEST["art_number"];
    $equ_number = $_REQUEST["equ_number"];
    $sql = "select * from equipment where art_number = '$art_number' and equ_number = '$equ_number'";
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
}
