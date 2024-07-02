
<?php
include(__DIR__ . '/../includes/db_lib.php');
include(__DIR__ . "/../includes/SessionCheck.php");
$type = $_REQUEST['brfields_type'];
$width = intval($_REQUEST['brfields_width']);
$height = intval($_REQUEST['brfields_height']);
$textsize = intval($_REQUEST['brfields_textsize']);
$enable = intval($_REQUEST['brfields_enable']);

update_lab_config_settings_barcode($type, $width, $height, $textsize, $enable);
?>
