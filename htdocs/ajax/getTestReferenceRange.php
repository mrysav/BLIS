<?php
include(__DIR__ . "/../includes/SessionCheck.php");
include(__DIR__ . "/../includes/db_lib.php");
echo json_encode(getTestReferenceRange($_REQUEST['id']));
?>