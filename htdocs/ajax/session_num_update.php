<?php
#
# Main page for updating counts for specimen session numbers
# Called via Ajax from new_specimen.php
#
include(__DIR__ . "/../includes/SessionCheck.php");
include(__DIR__ . "/../includes/db_lib.php");
$session_date_string = $_REQUEST['snum'];
update_session_number($session_date_string);
?>