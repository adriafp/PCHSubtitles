<?php include 'header.php';?>

<ul data-role="listview" data-autodividers="true" data-split-icon="gear" data-split-theme="d">
<?php
	$excluded_filename = array(
		'.',
//		'..',
		'.DS_Store'
	);
	$initial_dir = "/opt/sybhttpd/localhost.drives/HARD_DISK/Download/";
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
			if(in_array($file,$excluded_filename)){
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
			<li class="dir"><a href="?dir=<?php echo $param_dir.$d ?>" data-transition="slide"><?php echo $d ?></a></li>
			<?php
		}
		foreach($files_arr as $f){
			$count++;
			?>
			<li class="file" >
				<a href="subtitles.php?dir=<?php echo $param_dir ?>&file=<?php echo $f ?>" data-transition="slide"><?php echo $f ?></a>
<!--                <a href="subtitles.php?dir=--><?php //echo $param_dir ?><!--&file=--><?php //echo $f ?><!--" data-transition="slide">Options</a>-->
                <a href="#" onclick="return $.pchs.popup('file_<?php echo $count?>')" id="file_<?php echo $count?>" data-file="<?php echo $f ?>" data-rel="popup" data-transition="pop" data-position-to="window" data-icon="gear" data-theme="e">Actions...</a>
			</li>
			<?php
		}
//			if ($dh = opendir($dir)) {
//				while (($file = readdir($dh)) !== false) {
//					?>
<!--					<li class="--><?php //echo filetype($dir . $file)?><!--">--><?php //echo $file ?><!--</li>-->
<!--					--><?php
//				}
//				closedir($dh);
//			}
	}
?>
</ul>
<div data-role="popup" id="popupMenu" data-theme="d">
    <ul data-role="listview" data-inset="true" style="min-width:210px;" data-theme="d">
        <li data-role="divider" data-theme="e">Choose an action</li>
        <li><a href="#">View details</a></li>
        <li><a href="#">Edit</a></li>
        <li><a href="#">Disable</a></li>
        <li><a href="#" onclick="$.pchs.delete();">Delete</a></li>
    </ul>
</div>

<script type="text/javascript">
	$.pchs = {
		fileId: null,
		popup: function(id) {
			this.fileId = id;
            $('#popupMenu').popup('open');
		},
		delete: function() {
			$.post("delete.php", {dir: '<?php echo $param_dir ?>',file:$("#"+$.pchs.fileId).attr('data-file')}, function(obj) {
				if(obj.result) {
                    $("#"+$.pchs.fileId).closest("li").fadeOut().remove();
                    $('#popupMenu').popup('close');
				} else {
					alert("This file can not be removed!");
				}
			},"json");
		}
	};
</script>

<?php include 'footer.php';?>
