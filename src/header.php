<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="http://code.jquery.com/mobile/1.3.0/jquery.mobile-1.3.0.min.css" />
    <script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
    <script src="http://code.jquery.com/mobile/1.3.0/jquery.mobile-1.3.0.min.js"></script>
    <style>
        .ui-li .ui-btn-text a.ui-link-inherit {
			white-space: normal;
		}
        .ui-li-desc {
			white-space: normal;
		}
    </style>
</head>
<body>
<div data-role="page">
    <div data-role="header">
		<?php
			if($_SERVER['SCRIPT_NAME']!='/index.php') {
				$backLink = $_REQUEST['dir'];
			} else {
				if(!empty($_REQUEST['dir'])){
					if(lastIndexOf($_REQUEST['dir'],'/')>-1) {
						$backLink = substr($_REQUEST['dir'], 0, lastIndexOf($_REQUEST['dir'],'/'));
					} else {
						$backLink = "";
					}
				}
			}
			echo "<a href='/?dir=$backLink' data-icon='arrow-l'>Back</a>";
		?>
        <h1>PCH Subtitles Manager</h1>
        <a href="/" data-icon="home">Home</a>
        <!--        <a href="#mypanel" data-icon="bars">Menu</a>-->
    </div>
    <div data-role="content">