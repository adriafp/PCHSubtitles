<?php
header('Content-Type: text/json;');

$initial_dir = "/opt/sybhttpd/localhost.drives/HARD_DISK/Download/";
$dir_param = $_POST['dir'];
$file_param = $_POST['file'];
$fileName = $initial_dir.$dir_param.$file_param;
$fileNameExt = pathinfo($file_param, PATHINFO_EXTENSION);
if($fileNameExt=='srt') {
	shell_exec('rm -rf '.str_replace(')','\)',str_replace('(','\(',str_replace(' ','\ ',$fileName))));
	echo json_encode(array('result'=>true));
} else {
	echo json_encode(array('result'=>false));
}
?>