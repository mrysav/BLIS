<?php
require_once(__DIR__ . "/../includes/keymgmt.php");
require_once(__DIR__ . "/../includes/SessionCheck.php");
$val=$_REQUEST['val'];
KeyMgmt::write_enc_setting($val);
