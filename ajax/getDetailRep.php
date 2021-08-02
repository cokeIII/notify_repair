<?php
require_once "../connect.php";
$rep_id = $_REQUEST["rep_id"];
$sql = "select 
rep.equ_number,
equ.equ_name,
equ.equ_description,
rep.rep_description,
peo.people_dep_name,
art.dep_id,
art.art_number,
art.art_id,
art.level,
concat(art.art_number,' ',art.art_name) as art_number_name
from repair rep, equipment equ,people_dep peo,articles art
where rep.equ_number = equ.equ_number and 
equ.art_number = art.art_number and
art.dep_id = peo.people_dep_id and
rep.rep_id = '$rep_id'
";
$res = mysqli_query($conn, $sql);
$data = array();
$row = mysqli_fetch_array($res);
$data["equ_number"] = $row["equ_number"];
$data["equ_name"] = $row["equ_name"];
$data["equ_description"] = $row["equ_description"];
$data["rep_description"] = $row["rep_description"];
$data["people_dep_name"] = $row["people_dep_name"];
$data["art_number_name"] = $row["art_number_name"];
$data["dep_id"] = $row["dep_id"];
$data["art_number"] = $row["art_number"];
$data["art_id"] = $row["art_id"];
$data["level"] = $row["level"];


echo json_encode($data);
