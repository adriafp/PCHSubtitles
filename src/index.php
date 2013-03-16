<?php
	include_once "config.php";
	include 'header.php';
?>

<ul data-role="listview" data-inset="true" data-autodividers="true" data-divider-theme="e">
<?php

	$param_dir = '';
	if(isset($_GET['dir'])) {
		$param_dir = $_GET['dir'].'/';
	}
	$dir = $initial_dir . $param_dir;
	$count = 0;
	if (is_dir($dir)) {
		$files = scandir($dir);

		$dir_arr = array();
		$files_arr = array();

		foreach($files as $file) {
			if(in_array($file,$excluded_filename) || strpos($file,'.')==0){
				continue;
			}
			if(filetype($dir . $file)=='dir') {
				$dir_arr[] = $file;
			} else {
				$files_arr[] = $file;
			}
		}
		foreach($dir_arr as $d){
			?>
			<li class="dir" data-theme="c"><a href="?dir=<?php echo $param_dir.$d ?>" data-transition="none"><?php echo $d ?></a></li>
			<?php
		}
		?>
</ul>
<ul data-role="listview" data-inset="true" data-autodividers="true" data-divider-theme="b">
		<?php
		foreach($files_arr as $f){
			$count++;
			$fileExt = pathinfo($f, PATHINFO_EXTENSION);
			if($fileExt=='srt'){
			?>
				<li class="file" data-theme="c" data-icon="edit">
					<a href="fileoptions.php?dir=<?php echo $param_dir ?>&file=<?php echo $f ?>" data-transition="none"><?php echo $f ?></a>
				</li>
			<?php } else { ?>
				<li class="file" data-theme="c">
					<a href="subtitles.php?dir=<?php echo $param_dir ?>&file=<?php echo $f ?>" data-transition="none"><?php echo $f ?></a>
				</li>
			<?php
			}
		}
	}
?>
</ul>

<?php include 'footer.php';?>
