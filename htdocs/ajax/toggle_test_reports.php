<?php
/**
 * Created by PhpStorm.
 * User: SaiTeja
 * Date: 9/12/2016
 * Time: 11:34 PM
 */
include(__DIR__ . "/../includes/SessionCheck.php");
include(__DIR__ . "/../includes/db_lib.php");

$test_list_left = $_POST['test_list_left'];
$test_list_right = $_POST['test_list_right'];

TestType::updateReportingStatus($test_list_left, $test_list_right);
?>