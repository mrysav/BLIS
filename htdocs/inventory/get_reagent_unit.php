<?php
include(__DIR__ . "/../includes/db_lib.php");
    $id = $_REQUEST['id'];
    $lid = $_REQUEST['lid'];
    $unit = Inventory::getReagentUnit($lid, $id);
    if($unit == '')
        echo "-";
    else
        echo $unit;
?>
