<?php
    require_once "../connect.php";
    if(!empty($_REQUEST["delMap"])){
        $people_dep_id = $_REQUEST["people_dep_id"];
        $sql = "delete from map where people_dep_id = '$people_dep_id'";
        $res = mysqli_query($conn,$sql);
        if($res === TRUE){
            echo "success";
        } else {
            echo "fail";
        }
    }
