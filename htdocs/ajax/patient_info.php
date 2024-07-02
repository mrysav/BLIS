<?php
#
# Returns HTML showing patient information
# Called via Ajax from new_specimen.php
#
include(__DIR__ . "/../includes/SessionCheck.php");
include(__DIR__ . "/../includes/db_lib.php");
include(__DIR__ . "/../includes/page_elems.php");
require_once(__DIR__ . "/../lib/date_lib.php");

$page_elems = new PageElems();
$pid = $_REQUEST['pid'];
$page_elems->getPatientInfo($pid, 250); 
?>