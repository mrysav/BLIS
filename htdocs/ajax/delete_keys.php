<?php

include(__DIR__ . "/../includes/db_lib.php");
include(__DIR__ . "/../includes/SessionCheck.php");
$id=$_REQUEST['id'];
$ret=KeyMgmt::delete_key_mgmt($id);
echo $ret;
?>