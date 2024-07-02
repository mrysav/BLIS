<?php
# Returns a JSON list of usernames for a site location via Ajax
# Called from reports.php
include_once(__DIR__ . "/../includes/SessionCheck.php");
include_once(__DIR__ . "/../includes/db_lib.php");
include_once(__DIR__ . "/../includes/ajax_lib.php");

$user_list = get_users_by_site_map($_REQUEST['site']);
$json_params = array('optionValue', 'optionDisplay');
echo list_to_json($user_list, $json_params);
?>
