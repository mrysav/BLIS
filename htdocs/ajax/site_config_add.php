<?php
/**
 * Created by PhpStorm.
 * User: SaiTeja
 * Date: 9/29/2016
 * Time: 3:14 PM
 */
include(__DIR__ . "/../includes/SessionCheck.php");
include(__DIR__ . '/../includes/db_lib.php');
include(__DIR__ . '/../includes/page_elems.php');

$site_name = $_REQUEST['add_site_name'];
$lab_config_id = $_REQUEST['lab_config_id'];

Sites::addSite($lab_config_id, $site_name);
?>