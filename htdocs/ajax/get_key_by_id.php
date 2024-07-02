<?php

include(__DIR__ . "/../includes/db_lib.php");
include(__DIR__ . "/../includes/SessionCheck.php");
$id=$_REQUEST['id'];
$ret=KeyMgmt::getById($id);
$json = json_encode($ret);
echo $json;
?>