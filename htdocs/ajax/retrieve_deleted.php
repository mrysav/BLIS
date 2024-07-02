<?php
#
# Deletes a patient profile from DB
# Called via Ajax from lab_user_new.php
#
include(__DIR__ . "/../includes/db_lib.php");
include(__DIR__ . "/../includes/script_elems.php");
include(__DIR__ . "/../includes/page_elems.php");
include(__DIR__ . "/../includes/SessionCheck.php");
$item_id=$_REQUEST['item_id'];

if(isset($_REQUEST['ret_cat'])){
	$category = $_REQUEST['ret_cat'];
}else{ 
	$category = "test";
}
//$lab_config = LabConfig::getById($_SESSION['lab_config_id']);

$lab_config=$_SESSION['lab_config_id'];

$isSuccess = 0 ;

//echo "Params ".$test_id." Test ".$test->testId; 
if(retrieve_deleted_items($lab_config, $item_id, $category)){
	 $isSuccess = 1;
} 
echo $isSuccess;
?>