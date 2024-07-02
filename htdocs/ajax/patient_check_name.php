<?php
#
# Checks if the given patient name (or simlar) already exists
# Called via Ajax from find_patient.php
#
include(__DIR__ . "/../includes/SessionCheck.php");
include(__DIR__ . "/../includes/db_lib.php");
if(isset($_SESSION['country']))
	$country = $_SESSION['country'];
else
	$country = null;

$name = $_REQUEST['n'];
$name = strip_tags($name);

$name_exists = Patient::checkNameExists($name);
if($name_exists === false) {
	$nameExists = GlobalPatient::checkNameExists($name, $country);
	if( $nameExists === false )
		echo "falseCG";
	else 
		echo "trueG";
}
else
	echo "trueC";
db_close();
?>