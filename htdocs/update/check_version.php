<?php

include_once("redirect.php");
include_once(__DIR__ . "/../includes/db_lib.php");
include_once(__DIR__ . "/../includes/user_lib.php");
include_once(__DIR__ . "/../lang/lang_util.php");

LangUtil::setPageId("update");
global $VERSION;
$vers = $VERSION;
$check = checkVersionDataEntryExists($vers);
echo $check;
?>
