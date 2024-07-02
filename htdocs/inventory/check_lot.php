<?php

include("redirect.php");
include(__DIR__ . "/../includes/db_lib.php");


$id = $_REQUEST['id'];
$lid = $_REQUEST['lid'];
$lot = $_REQUEST['lot'];
$check = Inventory::checkLot($lid, $id, $lot);
echo $check;
?>
