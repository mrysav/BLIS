<?php

include("redirect.php");
include(__DIR__ . "/../includes/db_lib.php");

$name = $_REQUEST['name'];
$lid = $_REQUEST['lid'];
$check = Inventory::checkReagent($lid, $name);
echo $check;
?>
