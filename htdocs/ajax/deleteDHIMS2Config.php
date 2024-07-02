<?php
include(__DIR__ . "/../includes/SessionCheck.php");
include(__DIR__ . "/../includes/db_lib.php");
$dhims2 = new DHIMS2();
echo $dhims2->deleteItems($_REQUEST['l'],$_REQUEST['items']);
?>