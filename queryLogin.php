<?php
require_once "connect.php";
session_start();
$people_id = $_POST["people_id"];
$sql = "select 
p.people_id, 
concat(ifnull(p.people_name,''),' ',ifnull(p.people_surname,'')) as pName, 
pd.people_dep_id,
pd.people_dep_name
from people p
inner join people_pro pr
on p.people_id = pr.people_id
inner join people_dep pd
on pr.people_dep_id = pd.people_dep_id
where p.people_id = '".$people_id."'
";
$res = mysqli_query($conn,$sql);
$rowcount=mysqli_num_rows($res);
$adminList = array("220");
$_SESSION["people_status"] = "";
if($rowcount > 0){
    while($row = mysqli_fetch_array($res)){
        $_SESSION["people_id"] = $row["people_id"];
        $_SESSION["people_Name"] = $row["pName"];
        $_SESSION["people_dep_id"][] = $row["people_dep_id"];
        $_SESSION["people_dep_name"][] = $row["people_dep_name"];
        if(in_array($row["people_dep_id"],$adminList)){
            $_SESSION["people_status"] = "staff";
        }
    }
    
    if($_SESSION["people_status"] != "staff"){
        $_SESSION["people_status"] = "user";
    }
    echo "ok";
} else {
    echo $rowcount;
}


