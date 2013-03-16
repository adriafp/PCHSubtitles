<?php
include_once "config.php";
include 'header.php';

$dir_param = $_GET['dir'];
$file_param = $_GET['file'];

?>

<div data-role="controlgroup" data-type="horizontal">
    <a href="#" data-role="button" data-theme="e" data-icon="edit">Rename</a>
<!--    <a href="#" data-role="button">Mentions</a>-->
    <a href="delete.php?dir=<?php echo $dir_param ?>&file=<?php echo $file_param ?>" data-icon="delete" data-role="button" data-theme="e">Delete</a>
</div>

<?php
include 'footer.php';
?>
