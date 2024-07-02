<?php
include(__DIR__ . "/../includes/SessionCheck.php");
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

include(__DIR__ . "/../includes/db_lib.php");
$sid = $_REQUEST['sid'];
echo encodeSpecimenBarcode($sid, 0);
?>
