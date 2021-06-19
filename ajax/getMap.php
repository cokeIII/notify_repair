<?php
    require_once "../connect.php";
    if(!empty($_REQUEST["getMap"])){
        $sql = "select m.*,pd.people_dep_name from map m, people_dep pd where m.people_dep_id = pd.people_dep_id";
        $res = mysqli_query($conn,$sql);
        $data = array();
        $i = 0;
        while($row = mysqli_fetch_array($res)){
            $data[$i]["people_dep_id"] = $row["people_dep_id"];
            $data[$i]["people_dep_name"] = $row["people_dep_name"];
            $data[$i]["map_x"] = $row["map_x"];
            $data[$i]["map_y"] = $row["map_y"];
            $i++;
        }
        echo json_encode($data);
    }