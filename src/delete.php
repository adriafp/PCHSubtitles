<?php
include_once "config.php";

header('Content-Type: text/json;');

$dir_param = $_GET['dir'];
$file_param = $_GET['file'];
$fileName = $initial_dir.$dir_param.$file_param;
$fileNameExt = pathinfo($file_param, PATHINFO_EXTENSION);
if($fileNameExt=='srt') {
	shell_exec('rm -rf '.str_replace(')','\)',str_replace('(','\(',str_replace(' ','\ ',$fileName))));
}

header('Location: /?dir=' . $dir_param);
?>