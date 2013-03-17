<?php
include_once "config.php";
include "header.php";

$dir_param = $_GET['dir'];
$file_param = $_GET['file'];
$fileName = $initial_dir.$dir_param.'/'.$file_param;
$fileNameExt = pathinfo($file_param, PATHINFO_EXTENSION);
if($fileNameExt=='srt') {
	$data = file_get_contents($fileName);
	echo '<pre>'.$data.'</pre>';
}
include "footer.php";
?>