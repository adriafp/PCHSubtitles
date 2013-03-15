<?php include 'header.php';?>

<?php
$initial_dir = "/opt/sybhttpd/localhost.drives/HARD_DISK/Download/";
$dir_param = $_GET['dir'];
$file_param = $_GET['file'];
$fileName = $initial_dir.$dir_param.$file_param;

$matches = array();
preg_match('/S[0-9][0-9]E[0-9][0-9]/',strtoupper($file_param),$matches);

if(isset($matches[0])) {
	$episode = $matches[0];
	$tvShow = trim(str_replace('.',' ', substr($file_param,0,strpos($file_param,$episode))));
	search(strtolower(str_replace(' ','+',$tvShow.'+'.$episode)), $dir_param, $file_param);

} else if(!empty($_GET['q'])){
	search($_GET['q'], $dir_param, $file_param);
} else {
	//Is not a tv show file
	?>
	<form action="subtitles.php">
		<label for="q">Search a subtitle for file: <strong><?php echo $file_param?></strong></label>
		<input type="hidden" id="dir" name="dir" value="<?php echo $dir_param?>">
		<input type="hidden" id="file" name="file" value="<?php echo $file_param?>">
		<input type="text" id="q" name="q" value="<?php echo str_replace('.',' ',$file_param)?>">
		<input type="submit" data-icon="search" value="Search" data-theme="b"/>
	</form>
	<?php
}

function search($text, $dir_param, $file_param) {
	$feed_url = 'http://www.subdivx.com/feed.php?buscar='.$text;
	try {
		$rss = simplexml_load_file($feed_url);
		if($rss)
		{
			echo '<ul data-role="listview" data-theme="b">';
			$items = $rss->channel->item;
			foreach($items as $item)
			{
				$title = $item->title;
				$link = $item->link;
				$published_on = $item->pubDate;
				$description = $item->description;
				echo '<li><a href="download.php?dir='.$dir_param.'&file='.$file_param.'&l='.$link.'"><h2>'.$title.'</h2><p>'.$description.'</p></a>';
				echo '</li>';
			}
			echo '</ul>';
		}
	} catch(Exception $e) {
		var_dump($e);
	}
}

?>

<?php include 'footer.php';?>