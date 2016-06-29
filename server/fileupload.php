<?php
//Only for POST method
// Make sure file is not cached (as it happens for example on iOS devices)
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

// 2 minutes execution time
@set_time_limit(2 * 60);

$uploadDir = 'upload';
$todayDir = $uploadDir.DIRECTORY_SEPARATOR.date('Ymd',time());

// Create upload dir
if (!file_exists($uploadDir)) {
    @mkdir($uploadDir);
}

//Create today dir
if(!file_exists($todayDir)){
    @mkdir($todayDir);
}


if(isset($_REQUEST)){
    $fileType = $_REQUEST["type"];
}else{
    $fileType = $_FILES["file"]["type"];
}
$listOfFileType = array(
    'image/jpeg' => '.jpg',
    'image/png'  => '.png'
);
$fileName = $todayDir.DIRECTORY_SEPARATOR.uniqid('zr').$listOfFileType[$fileType];
move_uploaded_file($_FILES["file"]["tmp_name"],$fileName);
$src = 'server'.DIRECTORY_SEPARATOR.$fileName;
die('{"jsonrpc" : "2.0", "result" : "success", "src" : "'.$src.'"}');
?>