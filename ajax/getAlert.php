<?php
error_reporting(error_reporting() & ~E_NOTICE);
require_once "../connect.php";
session_start();
$people_id = $_SESSION["people_id"];
if (!empty($_REQUEST["admin"])) {
    $sql = "select * from repair rep, equipment equ where rep.equ_number = equ.equ_number order by rep_time desc limit 6";
    $res = mysqli_query($conn, $sql);
    $data = array();
    $i = 0;
    $noRead = 0;
    $arrRead = array();
    while ($row = mysqli_fetch_array($res)) {
        $data["data"][$i]["rep_id"] = $row["rep_id"];
        $data["data"][$i]["equ_number"] = $row["equ_number"];
        $data["data"][$i]["equ_name"] = $row["equ_name"];
        $data["data"][$i]["rep_status"] = $row["rep_status"];
        $data["data"][$i]["rep_time"] = $row["rep_time"];
        if ($row["user_read"] != "") {
            $arrRead = json_decode($row["user_read"], true);
            if(!in_array($people_id,$arrRead)){
                $noRead++;
            }   
        } else {
            $noRead++;
        }
        $i++;
    }
    $data["count"] = $noRead;
    echo json_encode($data);
} else if (!empty($_REQUEST["read"])) {
    $sqlList = "select user_read,rep_id from repair";
    $resList = mysqli_query($conn, $sqlList);
    $arrRead = array();
    while ($row = mysqli_fetch_array($resList)) {
        if ($row["user_read"] != "") {
            $arrRead = json_decode($row["user_read"]);
            if(!in_array($people_id,$arrRead)){
                array_push($arrRead, $people_id);
            }   
        } else {
            $arrRead = array();
            array_push($arrRead, $people_id);
        }
        $sqlRead = "update repair set user_read = '" . json_encode($arrRead, JSON_UNESCAPED_UNICODE) . "' where rep_id = '".$row["rep_id"]."'";
        $resRead = mysqli_query($conn, $sqlRead);
    }

    if ($resList) {
        echo "success";
    } else {
        echo $sql;
    }
}
