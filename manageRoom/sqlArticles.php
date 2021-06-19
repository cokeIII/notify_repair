  
<?php
require_once "../connect.php";
$art_number = $_POST["art_number"];
$art_name = $_POST["art_name"];
$art_amount = $_POST["art_amount"];
$art_com = $_POST["art_com"];
$art_instruction = $_POST["art_instruction"];
$art_type = $_POST["art_type"];
$json_art_instruction = implode(",", $art_instruction);
$people_dep_id = $_POST["people_dep_id"];

$files = $_FILES["art_pic"];
$file_ext = strtolower(end(explode('.', $files['name'])));
$target_dir = "../pic_rooms/";
$file_name = $art_number . "." . $file_ext;
$target_file = $target_dir . basename($file_name);
$res = array();
if (!empty($files['name'])) {
    if (is_image($files["tmp_name"]) === true) {
        move_uploaded_file($files["tmp_name"], $target_file);
    }
}
$sql = "insert into articles 
        (
        art_number,
        art_name,
        art_amount,
        art_com,
        art_instruction,
        art_type,        
        art_pic,
        dep_id ) values(
            '$art_number',
            '$art_name',
            '$art_amount',
            '$art_com',
            '$json_art_instruction',
            '$art_type',
            '$people_dep_id',
            '$file_name'
        )";
$result = $conn->query($sql);
if ($result) {
    header("location: room.php");
}
function is_image($path)
{
    $a = getimagesize($path);
    $image_type = $a[2];

    if (in_array($image_type, array(IMAGETYPE_GIF, IMAGETYPE_JPEG, IMAGETYPE_PNG, IMAGETYPE_BMP))) {
        return true;
    }
    return false;
}
