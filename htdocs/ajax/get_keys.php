<?php
require_once(__DIR__ . "/../includes/keymgmt.php");
require_once(__DIR__ . "/../includes/SessionCheck.php");

echo json_encode(KeyMgmt::getAllKeys());
