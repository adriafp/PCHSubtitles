<?php

include_once "config.php";

$dir_param = $_REQUEST['dir'];
$file_param = $_REQUEST['file'];
$extract = $_REQUEST['extract'];

if(!empty($extract)) {

	$ext = pathinfo($extract, PATHINFO_EXTENSION);

	if($ext=='rar') {
		execute('unrar e '.getcwd().'/'.$extract);
	} else if($ext=='zip') {
		execute('unzip '.getcwd().'/'.$extract);
	}
	execute('rm -rf *.rar');
	execute('rm -rf *.zip');
	processExtract($initial_dir, $dir_param, $file_param);
} else {

	$url = $_REQUEST['l'];
	$content = file_get_contents($url);
	$matchesDownloadLink = array();
	preg_match('/\?id=[0-9]*\&[a-zA-Z=0-9]*/', $content, $matchesDownloadLink);
	if(isset($matchesDownloadLink[0])) {
		$downloadLink = 'http://www.subdivx.com/bajar.php' . $matchesDownloadLink[0];
		$data = file_get_contents($downloadLink);
		$ext = 'tmp';
		if(strpos($data,'Rar') !== false) {
			$ext = 'rar';
		} else if (strpos($data, 'PK') !== false) {
			$ext = 'zip';
		}
		$tmp = file_put_contents('file.'.$ext, $data);

		if($ext=='rar') {
			execute('unrar e '.getcwd().'/file.rar');
		} else if($ext=='zip') {
			execute('unzip '.getcwd().'/file.zip');
		}
		processExtract($initial_dir, $dir_param, $file_param, $ext);
	}
}

function processExtract($initial_dir, $dir_param, $file_param) {
    global $script_dir;

	execute('rm -rf file.rar');
	execute('rm -rf file.zip');

	$files = scandir($script_dir);
	var_dump($files);
	$compressedFiles = array();
	foreach($files as $file) {
		if((pathinfo($file, PATHINFO_EXTENSION)=="rar"
			|| pathinfo($file_param, PATHINFO_EXTENSION)=='zip')
			&& $file!='file.rar'
			&& $file!='file.zip') {
			$compressedFiles[] = $file;
		}
	}
	if(count($compressedFiles)==0) {
		$fileNameExt = pathinfo($file_param, PATHINFO_EXTENSION);
		$basename = substr($file_param, 0, strpos($file_param, '.'.$fileNameExt));
		execute('mv *.srt '.$basename.'.srt');
		execute('rm -rf "'.$initial_dir.$dir_param.$basename.'.srt"');
		execute('mv '.getcwd().'/*.srt "'.$initial_dir.$dir_param.'"');
		header('Location: /?dir=' . $dir_param);
	} else {
		include "header.php";
		?>
    <ul data-role="listview" data-inset="true" data-theme="c">
		<?php foreach($compressedFiles as $file) {?>
        <li data-icon="gear"><a href="download.php?dir=<?php echo $dir_param ?>&file=<?php echo $file_param ?>&extract=<?php echo $file ?>"><?php echo $file?></a></li>
		<?php } ?>
        <!--            <li data-role="list-divider" data-theme="e">'.$file_param.'</li>-->
    </ul>
	<?php
		include "footer.php";
	}
}

?>