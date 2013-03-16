<?php

//CONFIG

$initial_dir = "/opt/sybhttpd/localhost.drives/HARD_DISK/";

$excluded_filename = array(
	'.',
	'..',
	'.DS_Store',
	'unrar.sh',
	'start_app.sh',
	'lost+found'
);

//UTILS

function execute($cmd) {
	$fp = fopen('pchsubtitles.log', 'a');
	fwrite($fp, '[DEBUG] Executing: ' . $cmd . PHP_EOL);
	$output = array();
	$return = -1;
	$res = exec($cmd,$output,$return);
	if(!empty($res))
		fwrite($fp, '[DEBUG] ' . $res . PHP_EOL);
	if(!empty($output)) {
		foreach($output as $line) {
			fwrite($fp, '[DEBUG] ' . $line . PHP_EOL);
		}
	}
	if(!empty($return))
		fwrite($fp, '[DEBUG] ' . $return . PHP_EOL);
	fclose($fp);
}

function lastIndexOf($string,$item){
	$index=strpos(strrev($string),strrev($item));
    if ($index){
		$index=strlen($string)-strlen($item)-$index;
		return $index;
	}
	else
		return -1;
}

function startsWith($haystack, $needle)
{
	return !strncmp($haystack, $needle, strlen($needle));
}

function endsWith($haystack, $needle)
{
	$length = strlen($needle);
	if ($length == 0) {
		return true;
	}

	return (substr($haystack, -$length) === $needle);
}

?>