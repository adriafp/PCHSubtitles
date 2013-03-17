<?php
include_once "config.php";
include 'header.php';

$dir_param = $_GET['dir'];
$file_param = $_GET['file'];
if($_REQUEST['o']=='rename') {
	$newfile_param = $_REQUEST['newfile'];

	execute('mv "'.$initial_dir.$dir_param.'/'.$file_param.'" "'.$initial_dir.$dir_param.'/'.trim($newfile_param).'"');
	header('Location: fileoptions.php?dir='.$dir_param.'&file='.$newfile_param);
}
?>

<h3><?php echo $file_param?></h3>
<div data-role="controlgroup" data-type="vertical">
    <a href="#popupRename" data-rel="popup" data-position-to="window" data-role="button" data-theme="e" data-icon="edit" data-transition="pop">Rename</a>
    <a href="view.php?dir=<?php echo $dir_param ?>&file=<?php echo $file_param ?>" data-icon="arrow-u" data-role="button" data-theme="e">View</a>
    <a href="#popupDialogDelete" data-rel="popup" data-icon="delete" data-position-to="window" data-inline="false" data-transition="pop" data-role="button" data-theme="e">Delete</a>
</div>

<!-- Rename -->
<div data-role="popup" id="popupMenu" data-theme="a">
    <div data-role="popup" id="popupRename" data-theme="a" class="ui-corner-all" data-dismissible="false">
        <form action="fileoptions.php?o=rename&dir=<?php echo $dir_param?>&file=<?php echo $file_param?>">
            <div style="padding:10px 20px;">
                <h3>Edit</h3>
				<label for="newfile">File name:</label>
				<textarea name="newfile" id="newfile" data-prevent-focus-zoom="true"><?php echo $file_param?></textarea>
                <a href="#" data-role="button" data-icon="back" data-rel="back" data-theme="c">Cancel</a>
                <button type="submit" data-theme="b" data-icon="check">Submit</button>
            </div>
        </form>
    </div>
</div>

<!-- Delete -->
<div data-role="popup" id="popupDialogDelete" data-overlay-theme="a" data-theme="c" data-dismissible="false" style="max-width:400px;" class="ui-corner-all">
    <div data-role="header" data-theme="a" class="ui-corner-top">
        <h1>Delete File?</h1>
    </div>
    <div data-role="content" data-theme="d" class="ui-corner-bottom ui-content">
        <h3 class="ui-title">Are you sure you want to delete this file?</h3>
        <p>This action cannot be undone.</p>
        <a href="#" data-role="button" data-inline="true" data-rel="back" data-theme="c">Cancel</a>
        <a href="delete.php?dir=<?php echo $dir_param ?>&file=<?php echo $file_param ?>" data-role="button" data-inline="true" data-rel="back" data-transition="flow" data-theme="b">Delete</a>
    </div>
</div>

<?php
include 'footer.php';
?>
