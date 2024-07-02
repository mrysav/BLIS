<?php
#
# Adds a new lab user account to DB
# Called via Ajax from lab_user_new.php
#
include(__DIR__ . "/../includes/SessionCheck.php");
include(__DIR__ . "/../includes/db_lib.php");
include(__DIR__ . "/../includes/script_elems.php");
include(__DIR__ . "/../includes/page_elems.php");
$script_elems = new ScriptElems();
$page_elems = new PageElems();

$saved_session = SessionUtil::save();

$usertype=$_REQUEST['u'];

$defaultoption=$_REQUEST['d'];

$rwoption=$_REQUEST['rw'];

$level =  add_user_type($usertype, $defaultoption, $rwoption);

echo $level;

?>

<?php SessionUtil::restore($saved_session); ?>