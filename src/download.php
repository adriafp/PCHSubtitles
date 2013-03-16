<?php

include_once "config.php";

$dir_param = $_GET['dir'];
$file_param = $_GET['file'];
$fileName = $initial_dir.$dir_param.$file_param;

shell_exec('rm -rf *.'.$ext);
shell_exec('rm -rf *.srt');

$content = file_get_contents($_GET['l']);

$matchesDownloadLink = array();
preg_match('/\?id=[0-9]*\&[a-zA-Z=0-9]*/', $content, $matchesDownloadLink);
if(isset($matchesDownloadLink[0])) {
	$downloadLink = 'http://www.subdivx.com/bajar.php' . $matchesDownloadLink[0];
	var_dump($downloadLink);
	echo '<br>';
	$data = file_get_contents($downloadLink);
	$ext = 'tmp';
	if(strpos($data,'Rar') !== false) {
		$ext = 'rar';
	} else if (strpos($data, 'PK') !== false) {
		$ext = 'zip';
	}
	$tmp = file_put_contents('file.'.$ext, $data);
	var_dump($tmp);
	echo '<br>';

	if($ext=='rar') {
		shell_exec('/opt/sybhttpd/localhost.drives/HARD_DISK/unrar.sh '.getcwd().'/file.rar');
	} else if($ext=='zip') {
		shell_exec('unzip '.getcwd().'/file.zip');
	}
	$fileNameExt = pathinfo($file_param, PATHINFO_EXTENSION);
	$basename = substr($file_param, 0, strpos($file_param, '.'.$fileNameExt));
	shell_exec('mv *.srt '.$basename.'.srt');
	shell_exec('rm -rf '.$initial_dir.str_replace(')','\)',str_replace('(','\(',str_replace(' ','\ ',$dir_param.$basename).'.srt')));
	shell_exec('mv '.getcwd().'/*.srt '.$initial_dir.str_replace(')','\)',str_replace('(','\(',str_replace(' ','\ ',$dir_param))));

}
header('Location: /?dir=' . $dir_param);
?>