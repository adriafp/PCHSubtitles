<?php
	include_once "config.php";
	include 'header.php';
?>

<?php

$dir_param = $_GET['dir'];
$file_param = $_GET['file'];
$fileName = $initial_dir.$dir_param.$file_param;

$matches = array();
preg_match('/S[0-9][0-9]E[0-9][0-9]/',strtoupper($file_param),$matches);

$showSearch = true;

if(!empty($_GET['q'])) {
	$out = search(strtolower($_GET['q']), $dir_param, $file_param);
	if(!empty($out)) {
		$showSearch = false;
		echo $out;
	}
} elseif(isset($matches[0])) {
	$episode = $matches[0];
	$tvShow = trim(str_replace('.',' ', substr($file_param,0,strpos($file_param,$episode))));
	$out = search(strtolower(str_replace(' ','+',$tvShow.'+'.$episode)), $dir_param, $file_param);
	if(!empty($out)) {
		$showSearch = false;
		echo $out;
	}
}

if ($showSearch) {
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
	$result = null;
	$feed_url = 'http://www.subdivx.com/feed.php?buscar='.$text;
	try {
		$rss = simplexml_load_file($feed_url);
		if($rss)
		{
			$result = '<ul data-role="listview" data-inset="true" data-theme="c">
			<li data-role="list-divider" data-theme="e">'.$file_param.'</li>';
			$items = $rss->channel->item;
			if(count($items)<=0) {
				return null;
			}
			foreach($items as $item)
			{
				$title = $item->title;
				$link = $item->link;
				$description = $item->description;
				$result .= '<li data-icon="arrow-d"><a href="download.php?dir='.$dir_param.'&file='.$file_param.'&l='.$link.'"><h2>'.$title.'</h2><p>'.$description.'</p></a>';
				$result .= '</li>';
			}
			$result .='</ul>';
		}
	} catch(Exception $e) {
		var_dump($e);
	}
	return $result;
}

?>

<?php include 'footer.php';?>