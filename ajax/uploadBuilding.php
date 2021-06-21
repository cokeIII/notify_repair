<?php
error_reporting( error_reporting() & ~E_NOTICE );
$files = $_FILES["picBuild"];
$level = $_REQUEST["level"];
$file_ext = strtolower(end(explode('.', $files['name'])));
$target_dir = "../pic_buildings/";
$file_name = $_POST["dep_id"] ."_".$level. ".jpg";
$target_file = $target_dir . basename($file_name);
$res = array();
if (!empty($files['name'])) {
    if (is_image($files["tmp_name"]) === true) {
        if (move_uploaded_file($files["tmp_name"], $target_file)) {
            $res["status"] = "uploadSuccess";
            $res["namePic"] = $file_name;

            echo json_encode($res);
        } else {
            $res["status"] = "uploadFail";
            $res["namePic"] = "";

            echo json_encode($res);
        }
    } else {
        $res["status"] = "no pic";
        $res["namePic"] = "";

        echo json_encode($res);
    }
} else {
    $res["status"] = "uploadSuccess";
    $res["namePic"] = "";

    echo json_encode($res);
}
function is_image($path)
{
	$a = getimagesize($path);
	$image_type = $a[2];
	
	if(in_array($image_type , array(IMAGETYPE_GIF , IMAGETYPE_JPEG ,IMAGETYPE_PNG , IMAGETYPE_BMP)))
	{
		return true;
	}
	return false;
}