<?php
include(__DIR__ . "/../includes/db_lib.php");
include(__DIR__ . "/../includes/page_elems.php");
include(__DIR__ . "/../includes/ajax_lib.php");
include(__DIR__ . "/../includes/SessionCheck.php");
$specimen_id = $_REQUEST['sid'];
$saved_db = DbUtil::switchToLabConfig($_SESSION['lab_config_id']);
$queryString = "select patient_id from specimen where specimen_id = ".$specimen_id;
$record = query_associative_one($queryString);
$patient = $record['patient_id'];
echo $patient;

?>