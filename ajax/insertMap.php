<?php
    require_once "../connect.php";
    if(!empty($_REQUEST["insertMap"])){
        $people_dep_id = $_REQUEST["people_dep_id"];
        $pic_build = $_REQUEST["pic_build"];
        $map_x = $_REQUEST["map_x"];
        $map_y = $_REQUEST["map_y"];
        $sql = "insert into map (people_dep_id,map_x,map_y,pic_build) values('$people_dep_id','$map_x','$map_y','$pic_build')";
        $res = mysqli_query($conn,$sql);
        if($res){
            echo "success";
        } else {
            echo "fail";
        }
    }